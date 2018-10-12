<?php 
require_once('config/const.php');
require_once('config/db.php');
require_once('config/function.php');
require_once('wishlist.php');
require_once('template/header.php');
require_once('template/nav.php');
?>

<h2 class="text-center bg-danger"><?php display_message(); ?></h2>
        
       <!-- ****** Cart Area Start ****** -->
        <div class="cart_area clearfix">
            <h2 class="container">Wish List</h2>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cart-table clearfix">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $confirm_logged = false;
                                    if (!$confirm_logged) {
                                        if (isset($_SESSION['user_logged'])) {
                                            $confirm_logged = true;
                                            wishlist();
                                            
                                        }else{
                                            redirect("index.php");
                                        }
                                    }else{
                                        redirect("index.php");
                                    }
                                    ?>        
                                </tbody>
                            </table>
                        </div>

                        <div class="cart-footer d-flex mt-30">
                            <div class="back-to-shop w-50">
                                <a href="search.php?search=&submit-search=">Continue shopping</a>
                            </div>
                            <div class="update-checkout w-50 text-right">
                                <a href="wishlist.php?clear">Clear list</a>
                                <a href="wishlist-show.php">Update list</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- ****** Cart Area End ****** -->

<?php 
require_once('template/footer.php');
?>