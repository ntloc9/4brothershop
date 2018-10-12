
<?php 

require($_SERVER['DOCUMENT_ROOT'].'/4brotherstech/config/db.php');
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
	header('Location:../../index.php?quanly=quanlysp&ac=ngay&date1=' . $date1 . '&date2=' . $date2);
}elseif (isset($_GET['full'])){
	header('Location:../../index.php?quanly=quanlysp&ac=full'); 	
}
elseif (isset($_GET['id'])) {
 	//xoa
 	$id =  $_GET['id'];
	$sql = "delete from product_attributes where product_id = '$id'";
	mysqli_query($conn,$sql);
	$sql = "delete from products where id = '$id'";
	if(!mysqli_query($conn,$sql)) {
		echo "<script>
		confirm('You can not delete this product because it existed in some transaction!');
		window.location.replace('http://localhost/4brotherstech/admincp/index.php?quanly=quanlysp&ac=lietke') ;
		</script>";		
	} else {
		header('Location:../../index.php?quanly=quanlysp&ac=lietke');
	}
}
?>