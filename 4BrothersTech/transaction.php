<?php
    require_once('config/const.php');
    require_once('config/db.php');
    require_once('config/function.php');
    include_once('template/header.php');
    include_once('template/nav.php');

    if (isset($_SESSION['user_logged'])) {

        $user_id = mysqli_real_escape_string($conn,$_SESSION['user_logged']);
        $query = "SELECT * FROM orders WHERE user_id = ".$user_id;
        $result = mysqli_query($conn,$query);
        //if (mysqli_num_rows($result)>0) {
    
?>
<div id="border" style="padding: 20px;background-color: white">
    <div class="container">
        <h2 style="text-align: center;">Transaction History</h2>
        
    </div>
    <table width="100%" border="1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Order Date</th>
                <th>Payment Method</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <?php while ($order = mysqli_fetch_array($result)) {?>
        <tbody>
            <tr>
                <td><?php echo $order['order_no']; ?></td>
                <td><?php echo $order['order_date']; ?></td>
                <td><?php echo $order['payment_method']; ?></td>
                <td><?php echo $order['total']; ?></td>
                <td><?php echo $order['status']; ?></td>
            </tr>
        </tbody>
        <?php }} ?>
    </table>  
</div>
<?php
    require_once('template/footer.php');
?>