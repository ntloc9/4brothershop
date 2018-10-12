
<?php  
require_once('config/const.php');
require_once('config/db.php');
require_once('config/function.php');
?>


<?php 
	
	if(isset($_GET['checkout'])){
		if (isset($_SESSION['user_logged'])) {
			if ($_SESSION['item_total'] > 0) {

				redirect('checkout-show.php');

			}else{
				set_message('There is no item on cart');
				redirect("cart-show.php");
			}
		}else{

			set_message('Login is required');
			redirect("cart-show.php");

		}
	}
		

	function checkout(){

		foreach ($_SESSION as $name => $value) {
			// echo $name;
			
			if (substr($name, 0, 8) == "product_"){
				global $conn;
				$length = strlen($name) - 8;
                                            // mục địch 2 dòng này là tính ra id để select querry
            	$id = substr($name, 8, $length);

            	$query = 'select * from products where id = ' . mysqli_real_escape_string($conn, $id);

	            $result = mysqli_query($conn, $query);

	            confirm($result);

	            $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

	            foreach ($products as $product) {

	            	$subtotal = $product['price'] * $value;

		            // echo $name;
		           	$showpro = <<<DELIMETER
					
					<li><span1>{$product['name']}</span1><span>&#36;$subtotal</span></li>

DELIMETER;
					echo $showpro;
				}
			}
		}
	}

	function info_user(){
		global $conn;

		$user_id = mysqli_real_escape_string($conn, $_SESSION['user_logged']);

		$query_grab_info_user = "select * from users where id = $user_id";

		$result = mysqli_query($conn, $query_grab_info_user);

		confirm($result);

		$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

		foreach ($users as $user) {
			
			$_SESSION['user_address'] = $user['address'];

			$showuser = <<<DELIMETER

                <div class="col-12 mb-3">
                    <label for="first_name">Name <span>*</span></label>
                    <input type="text" class="form-control" id="first_name" value="{$user['name']}" required>
                </div>
                <div class="col-12 mb-3">
                    <label for="country">Country <span>*</span></label>
                    <select class="custom-select d-block w-100" id="country">
                    <option value="th">Thanh Hóa</option>
                    <option value="sl">Sơn La</option>
                    <option value="vn" selected="">Việt Nam</option>
                    <option value="bd">Bình Dương</option>
                    <option value="bt">Bình Thuận</option>
                    <option value="mt">Miền Tây</option>
                    <option value="hls">Dãy Hoàng Liên Sơn</option>
                </select>
                </div>
                <div class="col-12 mb-3">
                    <label for="street_address">Address <span>*</span></label>
                    <input type="text" class="form-control mb-3" id="street_address" value="{$user['address']}">
                </div>
                <div class="col-12 mb-3">
                    <label for="phone_number">Phone number <span>*</span></label>
                    <input type="number" class="form-control" id="phone_number" min="0" value="{$user['phone']}">
                </div>
                <div class="col-12 mb-4">
                    <label for="email_address">Email address <span>*</span></label>
                    <input type="email" class="form-control" id="email_address" value="{$user['email']}">
                </div>

DELIMETER;

        echo $showuser;
		}
	}



 ?>