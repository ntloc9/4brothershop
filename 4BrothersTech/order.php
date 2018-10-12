<?php  

require_once('config/const.php');
require_once('config/db.php');
require_once('config/function.php');

?>


<?php 

	$user_id = mysqli_real_escape_string($conn, $_SESSION['user_logged']);
	$order_id;

	if (isset($_GET['place'])) {
		user_place_order();
		redirect("order-success.php?id=$user_id");
	}


	function user_place_order(){

		global $conn, $user_id, $order_id;

		// insert order zô bảng order
		$today = mysqli_real_escape_string($conn, date("Y-m-d"));
		$item_total = mysqli_real_escape_string($conn, $_SESSION['item_total']);

		$query_add_to_order = "insert into orders(user_id, order_date, payment_method, total, status) values ($user_id, '$today', 'cod', $item_total, 'Processing')";
		$result_add_order = mysqli_query($conn, $query_add_to_order);
		confirm($result_add_order);

		//lấy cái id order vừa mới đặt để đưa qua cart
		$query_grab_order_id = "select max(id) as id from orders";	
		$result_id = mysqli_query($conn, $query_grab_order_id);
		confirm($result_id);
		$row_order_id = mysqli_fetch_array($result_id, MYSQLI_ASSOC);
		$order_id = mysqli_real_escape_string($conn,$row_order_id['id']);

		// bắt đầu ép product từ cart zô bảng order_item
		$query_grab_product_from_cart = "select * from carts where user_id = $user_id";
		$result_grab_product = mysqli_query($conn, $query_grab_product_from_cart);
		confirm($result_grab_product);
		$products = mysqli_fetch_all($result_grab_product, MYSQLI_ASSOC);

		foreach ($products as $product) {
				
			$product_id = mysqli_real_escape_string($conn,$product['product_id']);
			$product_quantity = mysqli_real_escape_string($conn,$product['product_quantity']);
			$product_price = mysqli_real_escape_string($conn,$product['price']);
			$product_subtotal = mysqli_real_escape_string($conn,$product['subtotal']);

			$query_add_item_to_order_item = "insert into order_items(order_id, product_id, quantity, price, subtotal) values ($order_id, $product_id, $product_quantity, $product_price, $product_subtotal)";

			$result_add_item_to_order_item = mysqli_query($conn, $query_add_item_to_order_item);
			
			confirm($result_add_item_to_order_item);
		}

		// insert zô bảng order_address
		$user_address = mysqli_real_escape_string($conn, $_SESSION['user_address']);
		$query_add_order_to_order_address = "insert into order_address(order_id, address) values ($order_id, '$user_address')";  //bảng order_address đổi cột is_completed và estimated_delivery_time sang NULL
		$result_add_order_to_order_address = mysqli_query($conn, $query_add_order_to_order_address);
		confirm($result_add_order_to_order_address);

		// xóa mọi product ở cart sau khi place order
		$query_clear_cart = "delete from carts where user_id = $user_id"; 
        $result_clear_cart = mysqli_query($conn, $query_clear_cart);
        confirm($result_clear_cart);

        unset($_SESSION['user_address']);
        unset_product();
        unset_quantity_and_total();

        
	}


	// $query_grab_order_id = "select max(id) as id from orders where user_id = $user_id";	
	// $result_id = mysqli_query($conn, $query_grab_order_id);
	// confirm($result_id);
	// $row_order_id = mysqli_fetch_array($result_id, MYSQLI_ASSOC);
	// echo $order_id = mysqli_real_escape_string($conn,$row_order_id['id']);

?>