<?php  
require_once('config/const.php');
require_once('config/db.php');
require_once('config/function.php');
require('order.php');
// require_once('config/cart.php');

include('template/header.php');
include('template/nav.php');    
 ?>


 <?php if (isset($_GET['id'])): ?>
     <?php 
        $user_id = mysqli_real_escape_string($conn, $_GET['id']);

            //lấy cái id order vừa mới đặt
        $query_grab_order_id = "select max(id) as id from orders where user_id = $user_id";  
        $result_id = mysqli_query($conn, $query_grab_order_id);
        confirm($result_id);
        $row_order_id = mysqli_fetch_array($result_id, MYSQLI_ASSOC);
        $order_id = mysqli_real_escape_string($conn,$row_order_id['id']);

        $query_grab_user_order = "select * from orders where user_id = $user_id and id = $order_id";
        $result_user_order = mysqli_query($conn, $query_grab_user_order);
        confirm($result_user_order);
        $order = mysqli_fetch_array($result_user_order);
        $dateShow = formatDate($order['order_date']);

        $query_grab_order_item = "select * from order_items where order_id = $order_id";
        $result_order_item_by_id = mysqli_query($conn,$query_grab_order_item);
        $order_items = mysqli_fetch_all($result_order_item_by_id,MYSQLI_ASSOC); 

      ?>
        <div class="row" style="background-color: white">
            <div class="col-md-1"></div>
            <div class="col-md-10" id="customer-order">
                    <div class="box">
                        <h1>Order Success!</h1>

                        <p class="lead">Your order was placed on <strong><?php echo $dateShow ?></strong> and is currently <strong>being <?php echo strtolower($order['status']); ?></strong>.</p>
                        <p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th >Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($order_items as $order_item): ?>
                                <?php $p = grabProductDetails($order_item['product_id']); ?>
                                    <tr>
                                        <td><?php echo $p['name']; ?></td>
                                        <td><?php echo $order_item['quantity'] ?></td>
                                        <td>&#36;<?php echo $order_item['price'] ?></td>
                                        <td>&#36;<?php echo $order_item['subtotal'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Order subtotal</th>
                                        <th>&#36;<?php echo $order['total'] ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-right">Shipping and handling</th>
                                        <th>Free</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-right">Total</th>
                                        <th>&#36;<?php echo $order['total'] ?></th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>

                        <?php 
                            $query_grab_user = "select * from users  where id = $user_id";
                            $query_user = mysqli_query($conn, $query_grab_user);
                            $user = mysqli_fetch_array($query_user);
                         ?>

                        <div class="row addresses">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <h2>Shipping address</h2>
                                <p><?php echo $user['name']; ?>
                                    <br><?php echo $user['address'] ?>
                                    <br><?php echo $user['phone'] ?>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            <div class="col-md-1"></div>
        </div>
 
 <?php endif ?>

        
<?php include('template/footer.php') ?>