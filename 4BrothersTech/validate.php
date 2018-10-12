<?php 
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
	
function checkAdmin(){
	    global $user_email,$conn;
	    $query = "select * from `users` where email = '$user_email' limit 1";
	    $result = mysqli_query($conn,$query);
	    $user = mysql_fetch_assoc($result);
	    if($user['type']  == 'admin'){
	        return true;
	    } else {
	        return false;
	    }
	}
	
function enumDropdown($table_name, $column_name, $echo)
    {
        global $conn;
        $result = mysqli_query($conn,"SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
           WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'");
    
        $row = mysqli_fetch_array($result);
        $enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
    
        foreach($enumList as $value)
             $selectDropdown .= "<option value=".$value.">".$value."</option>";
    
    
        if ($echo)
            echo $selectDropdown;
    
        return $selectDropdown;
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
 ?>