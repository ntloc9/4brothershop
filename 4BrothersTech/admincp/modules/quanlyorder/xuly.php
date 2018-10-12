
 <?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/4BrothersTech/config/function.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/4BrothersTech/config/db.php');
 ?>

 <?php 

 	

 	if (isset($_GET['filter'])) {

 		// VÌ trong sql chỉ cho lấy từ ngày bé đến ngày lớn nên mất công phải làm vậy, còn bây giờ thì nhập ngày bé trc hay ngày lớn trước đều được
 		
 		$s1 = $_GET['from'];
 		$s2 = $_GET['to'];
 		
 		$d1=date_create("$s1");

 		$d2=date_create("$s2");

 		$diff=date_diff($d1,$d2);

 		$sosanh = $diff->format('%R%a');
 		
 		if (substr($sosanh, 0, 1) == "+") {
 			$date1 = $_GET['from'];
 			$date2 = $_GET['to'];
 		}else{
 			$date1 = $_GET['to'];
 			$date2 = $_GET['from'];
 		}
 		echo $date1;
 	
 		header('Location:../../index.php?quanly=quanlyorder&ac=ngay&date1=' . $date1 . '&date2=' . $date2);

 	}elseif (isset($_GET['full'])){
 		header('Location:../../index.php?quanly=quanlyorder&ac=full'); 	}

 	if (isset($_POST['sua'])) {
 		$id = mysqli_real_escape_string($conn, $_GET['id']);
 		$payment_method = mysqli_real_escape_string($conn, $_POST['Payment_Method']);
 		$order_no = mysqli_real_escape_string($conn, $_POST['Order_No']);
 		$status = mysqli_real_escape_string($conn, $_POST ['status']);
 		$sql = "UPDATE orders set order_no = '$order_no', payment_method = '$payment_method', status = '$status' where id = '$id'";
 		mysqli_query($conn,$sql);
 		header('Location:../../index.php?quanly=quanlyorder&ac=sua&id=' . $id);
  	}
  ?>