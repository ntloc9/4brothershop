<?php 
	$sql = "select * from orders";
	$result = mysqli_query($conn, $sql);
	$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
 ?>
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
		foreach ($orders as $order):
	 ?>
	<tr>
		<td><?php echo $order['id']; ?></td>
		<td><?php echo $order['user_id']; ?></td>
		<td><?php echo $order['order_no']; ?></td>
		<td><?php echo $order['order_date']; ?></td>
		<td><?php echo $order['payment_method']; ?></td>
		<td><?php echo $order['total']; ?></td>
		<td><?php echo $order['status']; ?></td>
		<td><a href="index.php?quanly=quanlyloaisp&ac=sua&id=<?php echo $order['id']; ?>">Change</a></td>
		<td><a href="modules/quanlyloaisp/xuly.php?id= <?php echo $order['id']; ?>">Delete</a></td>
	</tr>
	<?php endforeach ?>
	
</table>