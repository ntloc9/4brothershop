
 <?php 
	include('../config.php');
	$id = $_GET['id'];
	$email = $_POST['email'];
    $password = md5($_POST["password"]);  
    $address = $_POST["address"];
    $birthday = $_POST["birthday"];
    $name = $_POST["name"]; 
    $phone = $_POST["phone"];
    $type = $_POST["type"];

	if (isset($_POST['them'])) {
		//them
		$sql = "INSERT INTO users (email, password, address,birthday,name,phone,type) 
             VALUES ('$email','$password','$address','$birthday','$name','$phone','$type')";
		mysqli_query($conn,$sql);
		header('Location:../../index.php?quanly=quanlythongtin&ac=lietke');
	}elseif (isset($_POST['sua'])) {
		//sua
		$sql = "UPDATE users set password = '$password',type = '$type' where id = '$id'";
		mysqli_query($conn,$sql);
		header('Location:../../index.php?quanly=quanlythongtin&ac=lietke&id='.$id);
	}else{
		//xoa
		$sql = "DELETE from users where id = '$id'";
		mysqli_query($conn,$sql);
		header('Location:../../index.php?quanly=quanlythongtin&ac=lietke');
	}

 ?>