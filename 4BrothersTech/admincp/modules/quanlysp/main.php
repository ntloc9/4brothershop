
<?php 
include('modules/quanlysp/nut.php');

if (isset($_GET['ac'])) {
	$tam = $_GET['ac'];
}
else{
	$tam = '';
}

if ($tam == 'ngay') {
	$date1 = mysqli_real_escape_string($conn, $_GET['date1']);
	$date2 = mysqli_real_escape_string($conn, $_GET['date2']);
	echo "<a href='modules/quanlysp/exportExcel.php?ngay&date1=$date1&date2=$date2' target='_blank'>Export report</a>";
	echo "<table width='100%'' border='0'>";
	echo "<tr>";
	echo "<td>Product Name</td>";
	echo "<td>Order No</td>";
	echo "<td>User name</td>";
	echo "<td>Order Date</td>";
	echo "<td>Quantity</td>";
	echo "<td>Price</td>";
	echo "<td>Amount</td>";

	echo "</tr>";
	filter($date1,$date2); //gọi hàm lấy order theo ngày
	echo "</table>";

}	elseif ($tam == 'full') {
	echo "<a href='modules/quanlysp/exportExcel.php?full' target='_blank'>Xuất Excel Full</a>";
	echo "<table width='100%'' border='0'>";
	echo "<tr>";
	echo "<td>Product Name</td>";
	echo "<td>Order No</td>";
	echo "<td>User name</td>";
	echo "<td>Order Date</td>";
	echo "<td>Quantity</td>";
	echo "<td>Price</td>";
	echo "<td>Amount</td>";

	echo "</tr>";
	full();   //gọi hàm lấy full order
	echo "</table>";
}	elseif ($tam == 'sua') {
	include('modules/quanlysp/editProduct.php');
}  	elseif ($tam == 'lietke') {
	include('modules/quanlysp/lietke.php');
}	elseif ($tam == 'them') {
	include('modules/quanlysp/newProduct.php');
}


function full(){
	global $conn;
	//$query_full = "select * from orders";
	$query_full = "select o.order_no, u.name, oi.quantity, oi.subtotal , p.name as product_name, o.order_date, oi.price
	from products p, order_items oi, orders o, users u 
	where o.id = oi.order_id and u.id = o.user_id and p.id = oi.product_id
	order by p.id, o.order_date" ;
	$result = mysqli_query($conn, $query_full);
// confirm($result);
	$transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);

	foreach ($transactions as $transaction) {

		// $user_id = $order['user_id'];
		// $query_grab_user_name = "select a.name from users a, orders b where a.id = b.user_id and b.user_id = $user_id";
		// $query_user_name = mysqli_query($conn, $query_grab_user_name);
		// $user_name = mysqli_fetch_array($query_user_name);

		$showorder = <<<DELIMETER
		<tr>
		<td>{$transaction['product_name']}</td>
		<td>{$transaction['order_no']}</td>
		<td>{$transaction['name']}</td>
		<td>{$transaction['order_date']}</td>
		<td>{$transaction['quantity']}</td>
		<td>{$transaction['price']}</td>
		<td>{$transaction['subtotal']}</td>

		</tr>

DELIMETER;
		echo $showorder;

	}	
}


function filter($d1, $d2){
	global $conn;
	$date1 = mysqli_real_escape_string($conn, $d1);

	$date2 = mysqli_real_escape_string($conn, $d2);

	//$query_full = "select * from order_items where order_date between '$date1' and '$date2' order by product_id";
	$query_full = "select o.order_no, u.name, oi.quantity, oi.subtotal , p.name as product_name, o.order_date, oi.price
	from products p, order_items oi, orders o, users u 
	where o.order_date between '$date1' and '$date2' AND o.id = oi.order_id and u.id = o.user_id and p.id = oi.product_id
	order by p.id, o.order_date" ;

	// $result = mysqli_query($conn, $query_order);
	// $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$result = mysqli_query($conn, $query_full);
// confirm($result);
	$transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);

	foreach ($transactions as $transaction) {

		// $user_id = $order['user_id'];
		// $query_grab_user_name = "select a.name from users a, orders b where a.id = b.user_id and b.user_id = $user_id";
		// $query_user_name = mysqli_query($conn, $query_grab_user_name);
		// $user_name = mysqli_fetch_array($query_user_name);

		$showorder = <<<DELIMETER

		<tr>
		<td>{$transaction['product_name']}</td>
		<td>{$transaction['order_no']}</td>
		<td>{$transaction['name']}</td>
		<td>{$transaction['order_date']}</td>
		<td>{$transaction['quantity']}</td>
		<td>{$transaction['price']}</td>
		<td>{$transaction['subtotal']}</td>

		</tr>

DELIMETER;
		echo $showorder;

	}	

}
?>