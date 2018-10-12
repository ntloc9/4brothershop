<?php 
require_once('PHPExcel.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/4brotherstech/config/db.php');

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
	$objPHPExcel->getActiveSheet()->setTitle('Products Stock Position');

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 4, 'Product Number')->setCellValueByColumnAndRow(1, 4, 'Transaction Date')->setCellValueByColumnAndRow(2,4,'Invoice No')->setCellValueByColumnAndRow(3,4,'Customer Name')->setCellValueByColumnAndRow(4,4,'Quantity')->setCellValueByColumnAndRow(5,4,'Price')->setCellValueByColumnAndRow(6,4,'Amount');

	//Xét chiều rộng cho từng, nếu muốn set height thì dùng setRowHeight()
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);

	//Xét in đậm cho khoảng cột
	$objPHPExcel->getActiveSheet()->getStyle('A4:G4')->getFont()->setBold(true);

	// lấy orders ra để quăng vào excel
	$d1 = mysqli_real_escape_string($conn, $date1);
	$d2 = mysqli_real_escape_string($conn, $date2);

	$query_order = "select o.order_no, u.name, oi.quantity, oi.subtotal , p.name as product_name, o.order_date, oi.price
	from products p, order_items oi, orders o, users u 
	where o.order_date between '$d1' and '$d2' AND o.id = oi.order_id and u.id = o.user_id and p.id = oi.product_id
	order by p.id, o.order_date" ;

	$result = mysqli_query($conn, $query_order);
	$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$row3 = 5;

	foreach ($items as $item) {
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row3, $item['product_name']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row3, $item['order_date']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row3, $item['order_no']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row3, $item['name']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row3, $item['quantity']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row3, $item['price']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row3, $item['subtotal']);
		$row3++;
	}

	require_once 'PHPExcel/IOFactory.php';
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename='Stock Position Report from   $d1  to  $d2.xlsx'");
	PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007')->save('php://output');
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
	$objPHPExcel->getActiveSheet()->setTitle('Products Stock Position');

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 4, 'Product Number')->setCellValueByColumnAndRow(1, 4, 'Transaction Date')->setCellValueByColumnAndRow(2,4,'Invoice No')->setCellValueByColumnAndRow(3,4,'Customer Name')->setCellValueByColumnAndRow(4,4,'Quantity')->setCellValueByColumnAndRow(5,4,'Price')->setCellValueByColumnAndRow(6,4,'Amount');

	//Xét chiều rộng cho từng, nếu muốn set height thì dùng setRowHeight()
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);

	//Xét in đậm cho khoảng cột
	$objPHPExcel->getActiveSheet()->getStyle('A4:G4')->getFont()->setBold(true);

	// lấy orders ra để quăng vào excel
	$d1 = mysqli_real_escape_string($conn, $date1);
	$d2 = mysqli_real_escape_string($conn, $date2);

	$query_order = "select o.order_no, u.name, oi.quantity, oi.subtotal , p.name as product_name, o.order_date, oi.price
	from products p, order_items oi, orders o, users u 
	where  o.id = oi.order_id and u.id = o.user_id and p.id = oi.product_id
	order by p.id, o.order_date" ;

	$result = mysqli_query($conn, $query_order);
	$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$row3 = 5;

	foreach ($items as $item) {
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row3, $item['product_name']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row3, $item['order_date']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row3, $item['order_no']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row3, $item['name']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row3, $item['quantity']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row3, $item['price']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row3, $item['subtotal']);
		$row3++;
		$total += $item['subtotal'];
	}
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row3, 'TOTAL')->setCellValueByColumnAndRow(6,$row3,$total);
	$objPHPExcel->getActiveSheet()->getStyle('A4:G4')->getFont()->setBold(true);
	require_once 'PHPExcel/IOFactory.php';
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename='Stock Position Report.xlsx'");
	PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007')->save('php://output');

}



?>