
 <?php if (isset($_GET['id'])):
 	
 		$id = mysqli_real_escape_string($conn, $_GET['id']);
		$query_order_by_id = "select * from orders where id = $id";
		$result_order_by_id = mysqli_query($conn,$query_order_by_id);
		$orders = mysqli_fetch_all($result_order_by_id,MYSQLI_ASSOC); ?>

 	<?php foreach ($orders as $order): 

	 	$user_id = $order['user_id'];
		$query_grab_user_name = "select a.name from users a, orders b where a.id = b.user_id and b.user_id = $user_id";
		$query_user_name = mysqli_query($conn, $query_grab_user_name);
		$user_name = mysqli_fetch_all($query_user_name, MYSQLI_ASSOC);	?>

		<form action="modules/quanlyorder/xuly.php?id=<?php echo $order['id'] ?>" method="post" enctype="multipart/form-data">
				<table width="100%" border="0">
					<tr>
						<td colspan="2">
							<div align="center">Edit Order</div>
						</td>
					</tr>
					<tr>
						<td>User Name</td>
						<td><?php echo $user_name[0]['name'] ?></td>
					</tr>
					<tr>
						<td>Order No</td>
						<td><input type="text" name="Order_No" value="<?php echo $order['order_no'] ?>"></td>
					</tr>
					<tr>
						<td>Order Date</td>
						<td><?php echo $dateShow = formatDate($order['order_date']); ?></td>
					</tr>
					<tr>
						<td>Payment Method</td>
						<td><select name="Payment_Method"><?php enumDropdown('orders', 'payment_method', true, $order['payment_method']); ?></select></td>
					</tr>
					<tr>
						<td>Total</td>
						<td>&#36;<?php echo $order['total'] ?></td>
					</tr>
					<tr>
						<td>Status</td>
						<td><select name="status"><?php enumDropdown('orders', 'status', true, $order["status"]); ?></select></td>
					</tr>
					<tr>
						<td colspan="2"> <div align="center"><input class="btn btn-success" type="submit" name="sua" id="sua" value="Update"></div></td>
					</tr>
				</table>
			</form>
 		
 	<?php endforeach ?>
	
	<?php 
		$query_grab_order_item = "select * from order_items where order_id = $id";
		$result_order_item_by_id = mysqli_query($conn,$query_grab_order_item);
		$order_items = mysqli_fetch_all($result_order_item_by_id,MYSQLI_ASSOC);  
	?>

		<table width="100%" border="0">
			<tr>
				<td colspan="5">
					<div align="center">Ordered Item</div>
				</td>
			</tr>
			<tr>
				<td>Product ID</td>
				<td>Product Name</td>
				<td>Quanity</td>
				<td>Price</td>
				<td>Subtotal</td>
			</tr>
	<?php foreach ($order_items as $order_item): ?>

			<?php $p = grabProductDetails($order_item['product_id']); ?>
			<tr>	
				<td><?php echo $order_item['product_id'] ?></td>
				<td><?php echo $p['name']; ?></td>
				<td><?php echo $order_item['quantity'] ?></td>
				<td>&#36;<?php echo $order_item['price'] ?></td>
				<td>&#36;<?php echo $order_item['subtotal'] ?></td>
			</tr>
				
	<?php endforeach ?>
		</table>
	

 <?php endif ?>

