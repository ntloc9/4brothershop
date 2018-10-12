<?php 

require_once('config/const.php');
require_once('config/db.php');
require_once('config/function.php');
require_once('cart.php');
require_once('template/header.php');
require_once('template/nav.php');
 ?>

    <h2 class="text-center bg-danger"><?php display_message(); ?></h2>
        
       <!-- ****** Cart Area Start ****** -->
        <div class="cart_area section_padding_100 clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cart-table clearfix">
                            <table class="table" style="background-color: white">
                                <thead> 
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $confirm_logged = false;
                                    if (!$confirm_logged) {
                                        if (isset($_SESSION['user_logged'])) {
                                            $confirm_logged = true;
                                            bring_usercart_to_cart();
                                            cart();
                                        }else{
                                            cart();
                                        }
                                    }else{
                                        cart();
                                    }
                                    ?>        
                                </tbody>
                            </table>
                        </div>

                        <div class="cart-footer d-flex mt-30">
                            <div class="back-to-shop w-50">
                                <a href="search.php?search=&submit-search=">Continue shooping</a>
                            </div>
                            <div class="update-checkout w-50 text-right">
                                <a href="cart.php?clear">clear cart</a>
                                <a href="cart-show.php">Update cart</a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="coupon-code-area mt-70">
                            <div class="cart-page-heading">
                                <h5>Coupon code</h5>
                                <p>Enter your coupone code</p>
                            </div>
                            <form action="#">
                                <input type="search" name="search" placeholder="#569ab15">
                                <button type="submit">Apply</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="shipping-method-area mt-70">
                            <div class="cart-page-heading">
                                <h5>Shipping method</h5>
                                <p>Select the one you want</p>
                            </div>

                            <div class="custom-control custom-radio mb-30">
                                <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label d-flex align-items-center justify-content-between" for="customRadio1"><span>Next day delivery</span><span>$4.99</span></label>
                            </div>

                            <div class="custom-control custom-radio mb-30">
                                <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label d-flex align-items-center justify-content-between" for="customRadio2"><span>Standard delivery</span><span>$1.99</span></label>
                            </div>

                            <div class="custom-control custom-radio">
                                <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label d-flex align-items-center justify-content-between" for="customRadio3"><span>Personal Pickup</span><span>Free</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="cart-total-area mt-70">
                            <div class="cart-page-heading">
                                <h5>Cart total</h5>
                                <p>Final info</p>
                            </div>
                            <ul class="cart-total-chart">
                                <li><span>Item</span> <span><?php echo isset($_SESSION['item_quantity']) ? $_SESSION['item_quantity'] : $_SESSION['item_quantity'] =0; ?></span></li>
                                <li><span>Total</span> <span>&#36;<?php echo isset($_SESSION['item_total']) ? $_SESSION['item_total'] : $_SESSION['item_total'] =0; ?></span></li>
                                <li><span>Shipping fee</span> <span>Free</span></li>
                                <li><span><strong>Total with shipping fee</strong></span> <span><strong>&#36;<?php echo isset($_SESSION['item_total']) ? $_SESSION['item_total'] : $_SESSION['item_total'] =0; ?></strong></span></li>
                            </ul>
                            <a href="checkout-show.php?checkout" class="btn karl-checkout-btn">Proceed to checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ****** Cart Area End ****** -->

<?php  
    require_once('template/footer.php');

?>