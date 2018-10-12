<?php 
	require_once('config/const.php');
	require_once('config/connect.php');

function showdiscount() {
	$query = "SELECT * FROM products WHERE discount_price > 0";
    $result = mysqli_query($conn,$query);

    if (mysqli_num_rows($result)>0) {
    	while ($row = mysqli_fetch_assoc($result)) {
    		echo "<div class='col-sm-3'>
                                <div class='col-item' id='item1'>
                            	    <div class='photo'>
                                        <img src='../Image/CPU/AMD Ryzen 3 1300X/1.jpg' class='img-responsive tales'/>
                                    </div>    
                                    <div class='info'>
                                	    <div class='row'>
                                    	    <div class='price col-md-6'>
                                        	   <h5>".$row['name']."</h5>
                                        	   <h5 class='price-text-color'>$<strike>".$row['price']."</strike></h5>
                                        	   <h5 class='price-text-color'>$<span style='color: red;''>".$row['discound_price']."</span></h5>
                                            </div>
                                	    </div>
                                        <div class='separator clear-left'>
                                            <p class='btn-add'>
                                            <i class='fa fa-shopping-cart'></i><a href='' onclick='cart('item1')' class='hidden-sm'>Đặt hàng</a></p>
                                    	    <p class='btn-details'>
                                            <i class='fa fa-list'></i><a href='' class='hidden-sm'>Chi tiết</a></p>
                                    	</div>
                                        <div class='clearfix'>
                                        </div>
                                    </div>
                                </div>
                            </div>";
    	}
    }
}
?>