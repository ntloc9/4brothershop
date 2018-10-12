<?php  
require_once('config/const.php');
require_once('config/db.php');
require_once('config/function.php');
// require_once('config/db.php');
// include('template/header.php');
// include('template/nav.php');
?>


<?php

$confirm_logged;         

if (isset($_SESSION['user_logged'])) {
    $user_id = mysqli_real_escape_string($conn, $_SESSION['user_logged']);
}

if (isset($_GET['add'])) {

    $id = mysqli_real_escape_string($conn, $_GET['add']);

	$query_select_product = "select * from products where id = $id";
	$result_select_product = mysqli_query($conn, $query_select_product);
	confirm($result_select_product);
	$products = mysqli_fetch_all($result_select_product, MYSQLI_ASSOC);


	foreach ($products as $product) {

		if ($product['stock'] != $_SESSION['product_' . $_GET['add']]) {

            $_SESSION['product_' . $_GET['add']] +=1;

            if (isset($_SESSION['user_logged'])) {
                if (find_product_in_usercart($user_id, $id) > 0) {

                    $query_add_1_product = "update carts set product_quantity = product_quantity + 1 where user_id = $user_id and product_id = $id" ;
                    $result_add_1_product = mysqli_query($conn, $query_add_1_product);
                    confirm($result_add_1_product);


                } else{

                    $pPrice = mysqli_real_escape_string($conn,$product['price']);

                    $query_add_new = "insert into carts values ($user_id, $id, 1, $pPrice, $pPrice)";

                    $result_add_new = mysqli_query($conn, $query_add_new);
                    confirm($result_add_new);

                }

            }
			$_SESSION['item_quantity']++;
			redirect("cart-show.php");
			
		}else {
			set_message("Maximum quantity of " . $product['stock'] . " reached!");
			redirect("cart-show.php");
		}
	}
}


if(isset($_GET['remove'])) {

    $id = mysqli_real_escape_string($conn, $_GET['remove']);

    if($_SESSION['product_' . $_GET['remove']] > 0) {

        $_SESSION['product_' . $_GET['remove']]--;

        if (isset($_SESSION['user_logged']) && (find_product_in_usercart($user_id, $id) != 0)) {

            if (find_quantity_in_usercart($user_id, $id) <= 1) {
                $query_delete_product = "delete from carts where user_id = $user_id and product_id = $id";
                $result_delete_product = mysqli_query($conn, $query_delete_product);
                confirm($result_delete_product);
            }else{

                $query_remove_1_product = "update carts set product_quantity = product_quantity - 1 where user_id = $user_id and product_id = $id";
                $result_remove_1_product = mysqli_query($conn, $query_remove_1_product);
                confirm($result_remove_1_product);

            }
        }
        $_SESSION['item_quantity']--;
        redirect("cart-show.php");
    }else{

        unset_quantity_and_total();
        redirect("checkout.php");

    }
}


if(isset($_GET['delete'])) { 

    $id = mysqli_real_escape_string($conn, $_GET['delete']);

    $_SESSION['product_' . $_GET['delete']] = '0';

    unset_quantity_and_total();

    if (isset($_SESSION['user_logged']) && (find_product_in_usercart($user_id, $id) != 0)) {
        
        $query_delete_product_from_cart = "delete from carts where user_id = $user_id and product_id = $id";
        $result_delete_product_from_cart = mysqli_query($conn, $query_delete_product_from_cart);
        confirm($result_delete_product_from_cart);

    }   
    $_SESSION['item_quantity']-= $_SESSION['product_' . $_GET['delete']];
    redirect("cart-show.php");
}


if (isset($_GET['clear'])) {

    unset_product();

    if (isset($_SESSION['user_logged'])) {
        $query_clear_cart = "delete from carts where user_id = $user_id";
        $result_clear_cart = mysqli_query($conn, $query_clear_cart);
        confirm($result_clear_cart);
    }
    $_SESSION['item_quantity']=0;
    redirect("cart-show.php");
}



function find_quantity_in_usercart($uid, $pid){
    global $conn;
    $user_id = mysqli_real_escape_string($conn, $uid);
    $product_id = mysqli_real_escape_string($conn, $pid);

    $query_find = "select * from carts where user_id= $user_id and product_id = $product_id";

    $result = mysqli_query($conn, $query_find);

    confirm($result);

    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($products as $product) {
        return $product['product_quantity'];
    }
}



function find_product_in_usercart($uid, $pid){
     global $conn;
     $user_id = mysqli_real_escape_string($conn, $uid);
     $product_id = mysqli_real_escape_string($conn, $pid);

     $query_find = "select * from carts where user_id=" . $user_id . " and product_id = " . $product_id;

     $result = mysqli_query($conn, $query_find);

     confirm($result);

     return mysqli_num_rows($result);
}



function bring_usercart_to_cart(){

    global $conn, $confirm_logged;

    $user_id = mysqli_real_escape_string($conn, $_SESSION['user_logged']);
    // echo $user_id;
    $query = "select * from carts where user_id =" . $user_id;
    $result = mysqli_query($conn, $query);

    confirm($result);
    if (mysqli_num_rows($result) > 0){
        $cart_products = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($cart_products as $cart_product) {
            $_SESSION['product_' . $cart_product['product_id']] = $cart_product['product_quantity'];
        }
    }
}



function cart(){
    GLOBAL $conn, $confirm_logged;               //tổng tiền
    $total = 0;
    $item_quantity = 0;

    foreach ($_SESSION as $name => $value) {
        if (substr($name, 0, 8) == "product_" && $value > 0) {      //nếu có session product_ và giá trị > 0 thì render ra cart
           
            $length = strlen($name) - 8;
                                            // mục địch 2 dòng này là tính ra id để select querry
            $id = substr($name, 8, $length);

            $query = 'select * from products where id = ' . mysqli_real_escape_string($conn, $id);

            $result = mysqli_query($conn, $query);

            confirm($result);

            $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($products as $product) {
                if($product['discount_price'] > 0)
                    $product['price'] = $product['discount_price'];
                // dấu <<< là để gán nguyên đống đó cho biến, DELIMETER hay tên j cũng đc
                $subtotal = $product['price'] * $value;
                $item_quantity +=$value;
                $product_id = $product["id"];
                $files = glob("image/$product_id/*.*");
                if(!count($files))
                    $files[0] = 'template/noimage.jpg';

                $showpro = <<<DELIMETER
                    <tr>
                        <td class="cart_product_img d-flex align-items-center">
                            <a href="product-detail.php?id=$product_id"><img src="$files[0]" width="60px" alt="Product"></a>
                            <h6>{$product['name']}</h6>

                        </td>
                        <td class="price"><span>&#36;{$product['price']}</span></td>
                        <td class="qty">
                            <div class="quantity">
                                <input type="number" class="qty-text" id="qty" step="1" min="1" max="99" name="quantity" value="{$value}">
                            </div>
                        </td>
                        <td class="total_price"><span>&#36;$subtotal</span></td>
                        <td>
                            <a class = "btn btn-primary" href="cart.php?add={$product['id']}"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                            <a class = "btn btn-primary" href="cart.php?remove={$product['id']}"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                            <a class = "btn btn-danger" href="cart.php?delete={$product['id']}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>

DELIMETER;
                echo $showpro;
            }
        $total += $subtotal;
        }
    }
    $_SESSION['item_total'] = $total;  //tổng tiền
    $_SESSION['item_quantity'] = $item_quantity;  
}


 ?>


