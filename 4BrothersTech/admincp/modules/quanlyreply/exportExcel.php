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
$objPHPExcel->getActiveSheet()->setTitle('Reply Report');

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID')
->setCellValueByColumnAndRow(1, 1, 'Feedback_id')->setCellValueByColumnAndRow(2,1,'Title')->setCellValueByColumnAndRow(3,1,'Content')->setCellValueByColumnAndRow(4,1,'Status');


$query_user = "select * from replies";
$result = mysqli_query($conn, $query_user);
$replies = mysqli_fetch_all($result, MYSQLI_ASSOC);
$row3 = 2;

foreach ($replies as $reply) {
	$id = $reply['id'];
	$feedback_id = $reply['feedback_id'];
	$title = $reply['title'];
	$content = $reply['content'];
	$status = $reply['status'];

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row3,$id );
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row3,$feedback_id);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row3,$title);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row3,$content);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row3,$status);
	$row3++;
}

 ?>

 <?php 

 require_once 'PHPExcel/IOFactory.php';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// If you want to output e.g. a PDF file, simply do:
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
$objWriter->save('ReplyExel.xlsx');
echo "Successful!";
 ?>
<a href="../../index.php">Back to homepage</a>
 