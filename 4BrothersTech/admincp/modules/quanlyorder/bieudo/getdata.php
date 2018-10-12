<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/4brothersTech/config/function.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/4brothersTech/config/db.php');
 ?>


 <?php 

 $query = "select user_id, total from orders limit 0, 10";
 $result = mysqli_query($conn, $query);
 confirm($result);
 $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

 $data = array();
 foreach ($orders as $order) {
 	$data[] = $order;
 }
echo json_encode($data);

  ?>