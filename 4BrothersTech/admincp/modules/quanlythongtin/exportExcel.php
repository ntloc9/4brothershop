<?php require('config/db.php');?>
<?php require_once('PHPExcel.php'); ?>
<?php 


$objPHPExcel = new PHPExcel();
// Set getProperties
// $objPHPExcel->getProperties()->setCreator("Loc")
//                 ->setLastModifiedBy("Nguyễn Thành Lộc")
//                 ->setTitle("Demo tạo Excel bằng PHPExcel")
//                 ->setSubject("Demo tạo Excel bằng PHPExcel")
//                 ->setDescription("Tạo file Excel bằng PHPExcel bởi Nguyễn Thành Lộc")
//                 ->setKeywords("office 2007 openxml php")
//                 ->setCategory("Demo");
$objPHPExcel->getActiveSheet()->setTitle('Users');

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Tên người dùng')->setCellValueByColumnAndRow(1, 1, 'Email')->setCellValueByColumnAndRow(2,1,'Phone')->setCellValueByColumnAndRow(3,1,'Address')->setCellValueByColumnAndRow(4,1,'Birthday');


$query_user = "select * from users";
$result = mysqli_query($conn, $query_user);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
$row3 = 2;

foreach ($users as $user) {
	$name = $user['name'];
	$email = $user['email'];
	$phone = $user['phone'];
	$address = $user['address'];
	$birthday = $user['birthday'];

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row3,$name );
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row3,$email);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row3,$phone);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row3,$address);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row3,$birthday);
	$row3++;
}

 ?>

 <?php 

 require_once 'PHPExcel/IOFactory.php';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// If you want to output e.g. a PDF file, simply do:
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
$objWriter->save('UserExcel.xlsx');
echo "Successful!";
 ?>
<a href="../../index.php">Back to homepage</a>
 