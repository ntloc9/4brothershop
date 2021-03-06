<?php require_once('PHPExcel.php'); 
	require_once('db.php');
?>


<?php 

if (isset($_GET['full'])) {
	exportFull();
}elseif (isset($_GET['ngay'])) {
	$date1 = $_GET['date1'];
	$date2 = $_GET['date2'];
	exportdate($date1, $date2);
}

function exportdate($date1, $date2){
	global $conn;
	$objPHPExcel = new PHPExcel();
	// Set getProperties
	// $objPHPExcel->getProperties()->setCreator("Loc")
	//                 ->setLastModifiedBy("Nguyễn Thành Lộc")
	//                 ->setTitle("Demo tạo Excel bằng PHPExcel")
	//                 ->setSubject("Demo tạo Excel bằng PHPExcel")
	//                 ->setDescription("Tạo file Excel bằng PHPExcel bởi Nguyễn Thành Lộc")
	//                 ->setKeywords("office 2007 openxml php")
	//                 ->setCategory("Demo");
	$objPHPExcel->getActiveSheet()->setTitle('OrderByDate');

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Tên người dùng')->setCellValueByColumnAndRow(1, 1, 'Số hóa đơn')->setCellValueByColumnAndRow(2,1,'Số tiền')->setCellValueByColumnAndRow(3,1,'Ngày xuất HD')->setCellValueByColumnAndRow(4,1,'Phương thức thanh toán')->setCellValueByColumnAndRow(5,1,'Tổng Doanh Thu');

	// lấy orders ra để quăng vào excel
	$d1 = mysqli_real_escape_string($conn, $date1);
	$d2 = mysqli_real_escape_string($conn, $date2);

	$query_order = "select * from orders where order_date between '$d1' and '$d2'" ;
	$result = mysqli_query($conn, $query_order);
	$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$row3 = 2;

	foreach ($orders as $order) {

		// lấy tên người dùng ra
		$user_id = $order['user_id'];
		$query_grab_user_name = "select a.name from users a, orders b where a.id = b.user_id and b.user_id = $user_id";
		$query_user_name = mysqli_query($conn, $query_grab_user_name);
		$user_name = mysqli_fetch_all($query_user_name, MYSQLI_ASSOC);

		$order_id = $order['id'];
		$order_total = $order['total'];
		$order_date = $order['order_date'];
		$order_payment_method = $order['payment_method'];
		

		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row3, $user_name[0]['name']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row3, $order_id);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row3, '$'. $order_total);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row3, $order_date);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row3, $order_payment_method);
		$row3++;
	}


	$query_total = "select sum(total) as total from orders";
	$result_total = mysqli_query($conn, $query_total);
	$total = mysqli_fetch_all($result_total, MYSQLI_ASSOC);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5	, 2, '$'. $total[0]['total']);
	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, 'hi')
	//  								->setCellValueByColumnAndRow(1, 2, 'loc');

	 ?>

	 <?php 

	 require_once 'PHPExcel/IOFactory.php';
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	// If you want to output e.g. a PDF file, simply do:
	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
	$objWriter->save('OrderFrom' . $d1 . 'to' . $d2 . '.xlsx');
}


function exportFull(){
	global $conn;
	$objPHPExcel = new PHPExcel();
	// Set getProperties
	// $objPHPExcel->getProperties()->setCreator("Loc")
	//                 ->setLastModifiedBy("Nguyễn Thành Lộc")
	//                 ->setTitle("Demo tạo Excel bằng PHPExcel")
	//                 ->setSubject("Demo tạo Excel bằng PHPExcel")
	//                 ->setDescription("Tạo file Excel bằng PHPExcel bởi Nguyễn Thành Lộc")
	//                 ->setKeywords("office 2007 openxml php")
	//                 ->setCategory("Demo");
	$objPHPExcel->getActiveSheet()->setTitle('Loc');

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Tên người dùng')->setCellValueByColumnAndRow(1, 1, 'Số hóa đơn')->setCellValueByColumnAndRow(2,1,'Số tiền')->setCellValueByColumnAndRow(3,1,'Ngày xuất HD')->setCellValueByColumnAndRow(4,1,'Phương thức thanh toán')->setCellValueByColumnAndRow(5,1,'Tổng Doanh Thu');

	// lấy orders ra để quăng vào excel
	$query_order = "select * from orders";
	$result = mysqli_query($conn, $query_order);
	$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$row3 = 2;
	// lấy tên người dùng ra
	$query_grab_user_name = "select a.name from users a, orders b where a.id = b.user_id";
	$query_user_name = mysqli_query($conn, $query_grab_user_name);
	$user_name = mysqli_fetch_all($query_user_name, MYSQLI_ASSOC);


	foreach ($orders as $order) {

		// lấy tên người dùng ra
		$user_id = $order['user_id'];
		$query_grab_user_name = "select a.name from users a, orders b where a.id = b.user_id and b.user_id = $user_id";
		$query_user_name = mysqli_query($conn, $query_grab_user_name);
		$user_name = mysqli_fetch_all($query_user_name, MYSQLI_ASSOC);


		$order_id = $order['id'];
		$order_total = $order['total'];
		$order_date = $order['order_date'];
		$order_payment_method = $order['payment_method'];
		


		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row3, $user_name[0]['name']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row3, $order_id);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row3, '$'. $order_total);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row3, $order_date);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row3, $order_payment_method);
		$row3++;

	}


	$query_total = "select sum(total) as total from orders";
	$result_total = mysqli_query($conn, $query_total);
	$total = mysqli_fetch_all($result_total, MYSQLI_ASSOC);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5	, 2, '$'. $total[0]['total']);
	// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, 'hi')
	//  								->setCellValueByColumnAndRow(1, 2, 'loc');

	 ?>

	 <?php 

	 require_once 'PHPExcel/IOFactory.php';
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	// If you want to output e.g. a PDF file, simply do:
	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
	$objWriter->save('FullOrder.xlsx');

}



?>