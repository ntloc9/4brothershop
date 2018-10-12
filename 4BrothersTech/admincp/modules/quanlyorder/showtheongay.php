<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/project2/config/function.php');
	require_once('db.php');
	
 ?>

<h2 class="text-center"> Tổng doanh thu</h2>
<table width="100%" border="1">
	<tr>
		<td>ID</td>
		<td>User ID</td>
		<td>Order No</td>
		<td>Order Date</td>
		<td>Payment Method</td>
		<td>Total</td>
		<td>Status</td>
		<td colspan="2">Action</td>
		
	</tr>
		<?php 
			showfull();
		?>
</table>

<?php 

function showfull(){
	global $conn;
	
	$query_full = "select * from orders";

	$result = mysqli_query($conn, $query_full);
	confirm($result);
	$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
	foreach ($orders as $order) {
		$showorder = <<<DELIMETER
		<tr>
		<td>{$order['id']}</td>
		<td>{$order['user_id']}</td>
		<td>{$order['order_no']}</td>
		<td>{$order['order_date']}</td>
		<td>{$order['payment_method']}</td>
		<td>{$order['total']}</td>
		<td>{$order['status']}</td>
		<td><a href="index.php?quanly=quanlyloaisp&ac=sua&id={$order['id']}">Change</a></td>
		<td><a href="modules/quanlyloaisp/xuly.php?id={$order['id']}">Delete</a></td>
		</tr>

DELIMETER;
	echo $showorder;

	}	
}
 ?>