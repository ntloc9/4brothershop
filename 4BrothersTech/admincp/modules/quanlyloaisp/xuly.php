
 <?php 
	require($_SERVER['DOCUMENT_ROOT'].'/4brotherstech/config/db.php');
	include('../config/function.php');
	checkadmin();
	$id = $_GET['id'];
	$tenloaisp = $_POST['tenloaisp'];
	if (isset($_POST['them'])) {
		//them
		$sql = "insert into categories(category) value('$tenloaisp')";
		mysqli_query($conn,$sql);
		header('Location:../../index.php?quanly=quanlyloaisp&ac=them');
	}elseif (isset($_POST['sua'])) {
		//sua
		$sql = "update categories set category = '$tenloaisp' where id = '$id'";
		mysqli_query($conn,$sql);
		header('Location:../../index.php?quanly=quanlyloaisp&ac=sua&id='.$id);
	}else{
		//xoa
		$sql = "delete from categories where id = '$id'";
		mysqli_query($conn,$sql);
		header('Location:../../index.php?quanly=quanlyloaisp&ac=them');
	}

 ?>