<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/4brothersTech/config/function.php');
	require_once('db.php');
 ?>

<div class="left">
	<?php 
		include('modules/quanlyorder/nut.php');
	 ?>
</div>
<div class="right">
	<?php 

		if (isset($_GET['ac'])) {
			$tam = $_GET['ac'];
		}
		else{
			$tam = '';
		}
		if ($tam == 'ngay') {
			$date1 = mysqli_real_escape_string($conn, $_GET['date1']);
			$date2 = mysqli_real_escape_string($conn, $_GET['date2']);

			echo "<a class='btn btn-info' style='margin-bottom: 15px' href='modules/quanlyorder/exportExcel.php?ngay&date1=$date1&date2=$date2' target='_blank'>Xuất Excel Theo Ngày</a>";
			echo "<table width='100%'' border='0'>";
			echo "<tr>";
			echo "<td>ID</td>";
			echo "<td>User Name</td>";
			echo "<td>Order No</td>";
			echo "<td>Order Date</td>";
			echo "<td>Payment Method</td>";
			echo "<td>Total</td>";
			echo "<td>Status</td>";
			echo "<td colspan='2'>Action</td>";
			echo "</tr>";
			filter($date1,$date2); //gọi hàm lấy order theo ngày
			echo "</table>";
		}
		if ($tam == 'full') {
			echo "<table width='100%'' border='0'>";
			echo "<tr>";
			echo "<td>ID</td>";
			echo "<td>User Name</td>";
			echo "<td>Order No</td>";
			echo "<td>Order Date</td>";
			echo "<td>Payment Method</td>";
			echo "<td>Total</td>";
			echo "<td>Status</td>";
			echo "<td colspan='2'>Action</td>";
			echo "</tr>";
			full();   //gọi hàm lấy full order
			echo "</table>";
		}
		if ($tam = 'sua') {
			include('modules/quanlyorder/sua.php');
		}
			// if ($tam == 'showtheongay') {
			// 	include('modules/quanlyorder/showfull.php');
			// }
			// include('modules/quanlyorder/showfull.php');
	 ?>
</div>


<?php 


	function full(){
		global $conn;
		$Parr = paginate('orders', 10, 'quanly=quanlyorder&ac=full&');  //lấy số trang
		$query_full = "select * from orders " . $Parr['limit'];
		$result = mysqli_query($conn, $query_full);
		// confirm($result);
		$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

		foreach ($orders as $order) {

			$user_id = $order['user_id'];
			$query_grab_user_name = "select a.name from users a, orders b where a.id = b.user_id and b.user_id = $user_id";
			$query_user_name = mysqli_query($conn, $query_grab_user_name);
			$user_name = mysqli_fetch_array($query_user_name);

			//sửa lại ngày y/m/d thành d/m/y
			// $getdate = $order['order_date'];
			// $createdate = date_create($getdate);
			$dateShow = formatDate($order['order_date']);

			$showorder = <<<DELIMETER

			<tr>
			<td>{$order['id']}</td>
			<td>{$user_name['name']}</td>
			<td>{$order['order_no']}</td>
			<td>{$dateShow}</td>
			<td>{$order['payment_method']}</td>
			<td>{$order['total']}</td>
			<td>{$order['status']}</td>
			<td><a href="index.php?quanly=quanlyorder&ac=sua&id={$order['id']}">Change</a></td>
			</tr>

DELIMETER;
		echo $showorder;

		}	
		// echo '<nav aria-label="Page navigation example"><ul class="pagination">';
		echo $Parr['output'];
	    // echo '</ul></nav>';
	}


	function filter($d1, $d2){
		global $conn;
		$date1 = mysqli_real_escape_string($conn, $d1);

		$date2 = mysqli_real_escape_string($conn, $d2);

		$query_full = "select * from orders where order_date between '$date1' and '$date2' ";

		$result = mysqli_query($conn, $query_full);
		// confirm($result);
		$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

		foreach ($orders as $order) {

			$user_id = $order['user_id'];
			$query_grab_user_name = "select a.name from users a, orders b where a.id = b.user_id and b.user_id = $user_id";
			$query_user_name = mysqli_query($conn, $query_grab_user_name);
			$user_name = mysqli_fetch_array($query_user_name);

			//sửa lại ngày y/m/d thành d/m/y
			$dateShow = formatDate($order['order_date']);	
			
			$showorder = <<<DELIMETER

			<tr>
			<td>{$order['id']}</td>
			<td>{$user_name['name']}</td>
			<td>{$order['order_no']}</td>
			<td>{$dateShow}</td>
			<td>{$order['payment_method']}</td>
			<td>{$order['total']}</td>
			<td>{$order['status']}</td>
			<td><a href="index.php?quanly=quanlyorder&ac=sua&id={$order['id']}">Change</a></td>
			</tr>

DELIMETER;
		echo $showorder;

		}	
	}
 ?>