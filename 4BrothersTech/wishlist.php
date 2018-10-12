<?php  
require_once('config/const.php');
require_once('config/db.php');
require_once('config/function.php');
// require_once('config/db.php');
// require_once('template/header.php');
// require_once('template/nav.php');
?>

<?php

    if (isset($_GET['add'])) {
        $product_id = mysqli_real_escape_string($conn,$_GET['add']);
        $user_id = mysqli_real_escape_string($conn,$_SESSION['user_logged']);

        $query = "SELECT * FROM products WHERE id = $product_id";
        $result = mysqli_query($conn,$query);
        confirm($result);
        mysqli_num_rows($result)==1;

        if(!mysqli_num_rows(mysqli_query("SELECT * FROM  wishlists WHERE user_id = $user_id and product_id =  $product_id "))){
            $query_add_db = "INSERT INTO wishlists (user_id,product_id) VALUES ('.$user_id.','.$product_id.')";
            $result1 = mysqli_query($conn,$query_add_db);
            confirm($result1);
        }
        redirect('wishlist-show.php');
    }

    if (isset($_GET['delete'])) {

        $product_id = mysqli_real_escape_string($conn,$_GET['delete']);
        $user_id =$_SESSION['user_logged'];

        $query = "DELETE FROM wishlists WHERE product_id =$product_id AND user_id = $user_id";
        $result = mysqli_query($conn,$query);
        confirm($result);

        redirect('wishlist-show.php');
    }

    if (isset($_GET['clear'])) {

        $query_clear_cart = "delete from wishlists where user_id =" . mysqli_real_escape_string($conn, $_SESSION['user_logged']);
        $result = mysqli_query($conn, $query_clear_cart);
        confirm($result1);


        redirect("wishlist-show.php");
    }

    function wishlist(){

        GLOBAL $conn;

        $user_id = mysqli_real_escape_string($conn,$_SESSION['user_logged']);

        $query = "select products.* from products inner join wishlists on products.id = wishlists.product_id and wishlists.user_id =".$user_id;

        $result = mysqli_query($conn,$query);

        confirm($result);

        if (mysqli_num_rows($result) > 0) {

            $products = mysqli_fetch_all($result,MYSQLI_ASSOC);
            foreach ($products as $product) {
                $product_id = $product["id"];
                $files = glob("image/$product_id/*.*");
                if(!count($files))
                    $files[0] = 'template/noimage.jpg';
                $show = <<<DELIMETER
                    <tr>
                        <td class="cart_product_img d-flex align-items-center">
                            <a href="product-detail.php?id=$product_id"><img src="$files[0]" width="60px" alt="Product"></a>
                            <h6>{$product['name']}</h6>
                        </td>
                        <td class="price"><span>&#36;{$product['price']}</span></td>
                        <td>
                            <a style="" class = "btn btn-primary" href="cart.php?add={$product['id']}"><i class="fa fa-shopping-cart" aria-hidden="true">Add to cart</i></a>
                            </td>
                        <td>    
                            <a class = "btn btn-danger" href="wishlist.php?delete={$product['id']}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
DELIMETER;
            echo $show;     
            }   
        }
    }

   
function find_product_in_userwishlist($uid, $pid){
     global $conn;
     $user_id = mysqli_real_escape_string($conn, $uid);
     $product_id = mysqli_real_escape_string($conn, $pid);

     $query_find = "select * from wishlists where user_id=" . $user_id . " and product_id = " . $product_id;

     $result = mysqli_query($conn, $query_find);

     confirm($result);

     return mysqli_num_rows($result);
}



?>