    <?php 
require_once('config/const.php');
require_once('config/db.php');
require_once('config/function.php');
require_once('checkout.php');
require_once('template/header.php');
require_once('template/nav.php');
?>
    
        <!-- ****** Checkout Area Start ****** -->
        <div class="checkout_area section_padding_100">
            <div class="container" style="background-color: white">
                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="checkout_details_area mt-50 clearfix">

                            <div class="cart-page-heading">
                                <h5>Billing Address</h5>
                                <p>Enter your cupone code</p>
                            </div>
                                <div class="row">
                                    <?php info_user(); ?>
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox d-block mb-2">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1" disabled="">
                                            <label class="custom-control-label" for="customCheck1">PAYPAL ( chức năng hiện đang trong quá trình bảo trì)</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-block mb-2">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2" checked="">
                                            <label class="custom-control-label" for="customCheck2">Cash On Delivery</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-block">
                                            <input type="checkbox" class="custom-control-input" id="customCheck3" disabled="">
                                            <label class="custom-control-label" for="customCheck3">Internet Banking ( chức năng hiện đang trong quá trình bảo trì)</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                           <!--  <div class="cart-page-heading-bottom">
                                <h5>Infomation about payment option</h5>
                            </div>
                            <div id="accordion" role="tablist" class="mb-4">
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <h6 class="mb-0">
                                            <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne"><i class="fa fa-chevron-down" aria-hidden="true"></i>   Paypal</a>
                                        </h6>
                                    </div>
                                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integ er bibendum sodales arcu id te mpus. Ut consectetur lacus.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingTwo">
                                        <h6 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fa fa-chevron-down" aria-hidden="true"></i>   cash on delivery</a>
                                        </h6>
                                    </div>
                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quis in veritatis officia inventore, tempore provident dignissimos.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" role="tab" id="headingThree">
                                        <h6 class="mb-0">
                                            <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><i class="fa fa-chevron-down" aria-hidden="true"></i>   internet banking</a>
                                        </h6>
                                    </div>
                                    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse quo sint repudiandae suscipit ab soluta delectus voluptate, vero vitae</p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                        <div class="order-details-confirmation">

                            <div class="cart-page-heading">
                                <h5>Your Order</h5>
                                <p>The Details</p>
                            </div>

                            <ul class="order-details-form mb-4">
                                <li class="font-weight-bold"><span>Product</span> <span>Total</span></li>
                                <?php checkout(); ?>
                                <li><span class="font-weight-bold">Subtotal</span> <span>&#36;<?php echo isset($_SESSION['item_total']) ? $_SESSION['item_total'] : $_SESSION['item_total'] =0;  ?></span></li>
                                <li><span class="font-weight-bold">Shipping</span> <span>Free</span></li>
                                <li class="font-weight-bold"><span>Total</span> <span>&#36;<?php echo isset($_SESSION['item_total']) ? $_SESSION['item_total'] : $_SESSION['item_total'] =0; ?></span></li>
                            </ul>

                            <a href="order.php?place" class="btn karl-checkout-btn">Place Order</a>
                        </div>
                    </div>
        
                </div>
            </div>
        </div>
        <!-- ****** Checkout Area End ****** -->




<?php  
    require_once('template/footer.php');
?>