<?php 


function set_message($msg){
	if(!empty($msg)) {
		$_SESSION['message'] = $msg;
	} else {
		$msg = "";
	}
}

function display_message() {
	if(isset($_SESSION['message'])) {
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
}

function confirm($result){
	global $conn;
	if(!$result) {
		die("QUERY FAILED " . mysqli_error($conn));
	}
}

function redirect($location){
	return header("Location: $location ");
}

function validation_product() {
	global $name,$stock,$unit,$price,$warranty;
	global $nameError , $stockError , $unitError, $priceError, $warrantyError;
	$rs = true;
	if ( empty($name)) {
		$nameError .= "Name is required!<br/>";
		$rs = false;
	}
	if ( $stock <= 0) {
		$stockError .= "Stock must be larger than 0!<br/>";
		$rs = false;
	}
	if ( empty($unit)) {
		$unitError .= "Unit is required!<br/>";
		$rs = false;
	}
	if ( $price <= 0) {
		$priceError .= "Price must be larger than 0!<br/>";
		$rs = false;
	}
	if ($warranty <= 0) {
		$warrantyError .= "Warranty must be larger than 0!<br/>";
		$rs = false;
	}
	return $rs;
}

function enumDropdown($table_name, $column_name, $echo, $selVal)
{
	$selectDropdown = "";
	global $conn;
	if($selVal == null) {
    	// $selectDropdown = "$column_name\">";
		$result = mysqli_query($conn,"SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'");
		$row = mysqli_fetch_array($result);
		$enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
		foreach($enumList as $value)
			$selectDropdown .= "<option value=".$value.">".$value."</option>";
		// $selectDropdown .= "</select>";
		if ($echo)
			echo $selectDropdown;
		return $selectDropdown;
  	}else{
  		
  		// $selectDropdown = "$column_name\">";
		$result = mysqli_query($conn,"SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
			WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'");
		$row = mysqli_fetch_array($result);
		$enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
		foreach($enumList as $value)
			if ($selVal == $value) {
				$selectDropdown .= "<option value=".$value." selected>".$value."</option>";
			}else{
				$selectDropdown .= "<option value=".$value.">".$value."</option>";
			}
		// $selectDropdown .= "</select>";
		if ($echo)
			echo $selectDropdown;
		return $selectDropdown;

  	}
	
}

function validation_user(){
	global  $email ,$password, $address, $birthday, $name ,$phone ,$type ;
	global  $emailErr ,$passwordErr ,$addressErr ,$birthdayErr ,$nameErr ,$phoneErr ,$typeErr, $err;
	$rs = true;
	if (empty($email) || empty($password) || empty($address) || empty($birthday) || empty($name) || empty($phone) || empty($type)) 
	{
		echo "
		<div class='alert alert-warning'>
		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>PLease Fill all fields..!</b>
		</div>
		";
		exit();
	}
}	
function unset_product(){
	foreach ($_SESSION as $name => $value) {
		if (substr($name, 0, 8) == "product_") {
			unset($_SESSION[$name]);
		}
	}
}

function unset_quantity_and_total(){
	unset($_SESSION['item_total']);
	unset($_SESSION['item_quantity']);
}

function checkAdmin()
{
	if ($_SESSION['user_type'] != "admin") {
		header('Location: '.ROOT_URL.'index.php');
	}
}

function showdiscount() {
	global $conn;
	$query = "SELECT * FROM products WHERE discount_price > 0";
    $result = mysqli_query($conn,$query);
    $i=1;
    $active="active";
    if (mysqli_num_rows($result)>0) {
    	while ($row = mysqli_fetch_assoc($result)) {
    		$product_id = $row["id"];	
			$files = glob("image/$product_id/*.*");
			if(!count($files))
				$files[0] = 'template/noimage.jpg';

    		if($i % 4 == 1)
    			{echo " <div class='carousel-item $active'>
                        <div class='row'>";}
    			showProduct($product_id);
     		if($i % 4 == 0) {
     			echo " </div></div>";
     		}   
    		
           	if($i % 4 != 0 && $i==mysqli_num_rows($result) ) {
           		echo "<div class='col-sm-9'></div>";
    			echo "</div></div>";
           	}
    		$i++;
           	$active="";
    	}
    }
}

function showProduct($product_id) {
	global $conn;
	$query = "SELECT * FROM products WHERE id = $product_id";
	$product =  mysqli_fetch_assoc(mysqli_query($conn,$query));

	$files = glob("image/$product_id/*.*");
	if(!count($files))
		$files[0] = 'template/noimage.jpg';
	echo "<div class='col-sm-3' >
			<div class='col-item' style='margin-bottom: 10px;'>
				<div class='photo'><a href='product-detail.php?id=$product_id'><img src='$files[0]'/></a></div>
				<div class='info'>
					<h6>".substr($product['name'],0,40)."</h6>
					<p>Price : <span style='color: red;'>".$product['price']."$</span></p>";
					if($product['discount_price'] <> 0)	{
						echo "<p id='discount'>Sale Price : ".$product['discount_price']."$</p>";
					}

	echo		"</div>
			</div>
		</div>";

}

function sendMail($title, $content, $nTo, $mTo,$diachicc=''){
	global $mail; 
    $nFrom = '4BrothersTech Admin';
    $mFrom = '4BrothersTechvn@gmail.com';  //dia chi email cua ban 
    $mPass = '246357chunhat';       //mat khau email cua ban
    $body             = $content;
    $mail->IsSMTP(); 
    $mail->CharSet   = "utf-8";
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;                    // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";        
    $mail->Port       = 465;
    $mail->Username   = $mFrom;  // GMAIL username
    $mail->Password   = $mPass;               // GMAIL password
    $mail->SetFrom($mFrom, $nFrom);
    //chuyen chuoi thanh mang
    $ccmail = explode(',', $diachicc);
    $ccmail = array_filter($ccmail);
    if(!empty($ccmail)){
        foreach ($ccmail as $k => $v) {
            $mail->AddCC($v);
        }
    }
    $mail->Subject    = $title;
    $mail->MsgHTML($body);
    $address = $mTo;
    $mail->AddAddress($address, $nTo);
    $mail->AddReplyTo('info@freetuts.net', 'Freetuts.net');
    if(!$mail->Send()) {
        return 0;
    } else {
        return 1;
    }
}
 
function sendMailAttachment($title, $content, $nTo, $mTo,$diachicc='',$file,$filename){
    $nFrom = '4BrothersTech Admin';
    $mFrom = '4BrothersTechvn@gmail.com';  //dia chi email cua ban 
    $mPass = '246357chunhat';       //mat khau email cua ban
    $mail             = new PHPMailer();
    $body             = $content;
    $mail->IsSMTP(); 
    $mail->CharSet   = "utf-8";
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;                    // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";        
    $mail->Port       = 465;
    $mail->Username   = $mFrom;  // GMAIL username
    $mail->Password   = $mPass;               // GMAIL password
    $mail->SetFrom($mFrom, $nFrom);
    //chuyen chuoi thanh mang
    $ccmail = explode(',', $diachicc);
    $ccmail = array_filter($ccmail);
    if(!empty($ccmail)){
        foreach ($ccmail as $k => $v) {
            $mail->AddCC($v);
        }
    }
    $mail->Subject    = $title;
    $mail->MsgHTML($body);
    $address = $mTo;
    $mail->AddAddress($address, $nTo);
    $mail->AddReplyTo('4BrothersTechvn@gmail.com', '4BrothersTech Admin');
    $mail->AddAttachment($file,$filename);
    if(!$mail->Send()) {
        return 0;
    } else {
        return 1;
    }
}

function grabProductDetails($product_id){
	global $conn;
	$product_arr = array();
	$id = mysqli_real_escape_string($conn, $product_id);
	$query_grab_product_details = "select * from products where id = $id";
	$result_grab_product_details = mysqli_query($conn, $query_grab_product_details);
	$product = mysqli_fetch_array($result_grab_product_details);
	$product_arr['name'] = $product['name'];
	$product_arr['price'] = $product['price'];
	$product_arr['unit'] = $product['unit']; 
	return $product_arr;
}

function formatDate($getdate){
	//sửa lại ngày y/m/d thành d/m/y
	$createdate = date_create($getdate);
	$dateShow = date_format($createdate,"d/m/Y");
	return $dateShow;
}

  //show sp theo category
function showProductbyCategory($category_id){
	global $conn;
	
	$query = "SELECT * FROM products WHERE category_id =  $category_id  ";
	$result = mysqli_query($conn,$query);
	$queryResult = mysqli_num_rows($result);

	echo "<div  id='product'><div class='row' id='row'>";
	if ($queryResult > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$product_id = $row["id"];	
			$files = glob("image/$product_id/*.*");
			if(!count($files))
				$files[0] = 'template/noimage.jpg';
			showProduct($product_id);
		}
	}
	echo "</div></div>";
}

//show sp theo branch
function showProductbyBranch($branch_id){
	global $conn;
	$query = "SELECT * FROM products WHERE branch_id =  $branch_id";
	$result = mysqli_query($conn,$query);
	$queryResult = mysqli_num_rows($result);

	echo "<div  id='product'><div class='row' id='row'>";
	if ($queryResult > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$product_id = $row["id"];	
			$files = glob("image/$product_id/*.*");
			if(!count($files))
				$files[0] = 'template/noimage.jpg';
			showProduct($product_id);
		}
	}
	echo "</div></div>";
}


function paginate($table, $itemPerPage, $link = null) {
	global $conn;

	$query = 'select * from '.$table;
	$result = mysqli_query($conn, $query);
	confirm($result);
	$rows = mysqli_num_rows($result); // Lấy tổng record

	if(isset($_GET['page'])){ // lấy số trang
	    $page = preg_replace('#[^0-9]#', '', $_GET['page']);//chỉ lấy số khi nhập trang từ thanh address
	} else{// Mặc đinh cho nó = 1 nếu ko có ?page
	    $page = 1;
	}
	$perPage = $itemPerPage; // Số item 1 page
	$lastPage = ceil($rows / $perPage); // trang cuối


	if($page < 1){ 
	    $page = 1; // Cho nó = 1 nếu nó nhỏ hơn 1
	}elseif($page > $lastPage){ // 
	    $page = $lastPage; // cho nó = số trang cuôi nếu nó lớn hơn trang cuối
	}

	$middleNumbers = ''; 

	$sub1 = $page - 1;
	$sub2 = $page - 2;
	$add1 = $page + 1;
	$add2 = $page + 2;

	if($page == 1){

	      $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';

	      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'.$link.'page='.$add1.'">' .$add1. '</a></li>';

	} elseif ($page == $lastPage) {
	    
	      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'.$link.'page='.$sub1.'">' .$sub1. '</a></li>';
	      $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';

	}elseif ($page > 2 && $page < ($lastPage -1)) {

	      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'.$link.'page='.$sub2.'">' .$sub2. '</a></li>';

	      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'.$link.'page='.$sub1.'">' .$sub1. '</a></li>';

	      $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';

          $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'.$link.'page='.$add1.'">' .$add1. '</a></li>';

	      $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'.$link.'page='.$add2.'">' .$add2. '</a></li>';

	} elseif($page > 1 && $page < $lastPage){

	     $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'.$link.'page='.$sub1.'">' .$sub1. '</a></li>';

	     $middleNumbers .= '<li class="page-item active"><a class="page-link">' .$page. '</a></li>';
	 
	     $middleNumbers .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'.$link.'page='.$add1.'">' .$add1. '</a></li>';
	}


	// Query limit trong sql

	$limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;
	$outputPagination = ""; 

	  // thằng này là cái cần xuất ra

	if($page != 1){
	    $prev  = $page - 1;
	    $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'.$link.'page='.$prev.'">Back</a></li>';
	}

	$outputPagination .= $middleNumbers;

	if($page != $lastPage){
	    $next = $page + 1;
	    $outputPagination .='<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'.$link.'page='.$next.'">Next</a></li>';
	}

	$POut = '<nav aria-label="Page navigation example"><ul class="pagination">' . $outputPagination . '</ul></nav>';
	$pageArr = array('limit' => $limit , 'output' => $POut );
	return $pageArr;
}


?>




