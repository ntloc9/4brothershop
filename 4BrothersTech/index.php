<?php  
  require_once('config/db.php');
	require_once('config/const.php');
  require_once('config/function.php');
 	require_once('template/header.php');
 	require_once('template/nav.php');
?>

<section>
	<div id="myCarousel" class="carousel slide" data-ride="carousel" style="width: 100%; margin: 0 auto; margin-top: 10px" data-interval="3000">
  		<ol class="carousel-indicators">
    		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    		<li data-target="#myCarousel" data-slide-to="1"></li>
    		<li data-target="#myCarousel" data-slide-to="2"></li>
  		</ol>
  		<div class="carousel-inner">
    		<div class="carousel-item active">
      			<img class="carouselimg" src="template/38751760_2173358239616529_9009297054207311872_n.png" alt="">
    		</div>
    		<div class="carousel-item">
      			<img class="carouselimg" src="template/38765841_251564989002298_459072703328944128_n.png" alt="">
    		</div>
    		<div class="carousel-item">
      			<img class="carouselimg" src="template/38779240_297550510978807_3144900991162253312_n.jpg" alt="">
    		</div>
  		</div>
  		<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
    		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
    		<span class="sr-only">Previous</span>
  		</a>
  		<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
    		<span class="carousel-control-next-icon" aria-hidden="true"></span>
    		<span class="sr-only">Next</span>
  		</a>
	</div>
</section>
<div id="border">
    <div id="producttitle">
        <div class="container">
            <div id="title">
                <h4><b><i>FLASH SALES</i></b></h4>
            </div>
        </div>
    </div>
    <div class="container" id="product">
	   <div class="row">
		    <div id="carouselproduct" class="carousel slide" data-ride="carousel">
		      	<div class="carousel-inner">
                    <?php showdiscount(); ?>
                </div>
	       </div>		
        </div>
    </div>
</div>

<div id="img">
    <img src="template/refund-gaming-promotion_master.jpg">
</div>

<!-- <div id="border">
    <div id="producttitle">
        <div class="container">
            <div id="title">
                <h4>Linh kiện máy tính</h4>
            </div>
        </div>
    </div>
    <div class="container" id="product">
        
            
        
    </div>
</div> -->
<script>
  window.onscroll = function() {myFunction()};

  var navbar = document.getElementById("navbar");
  var sticky = navbar.offsetTop;

  function myFunction() {
    if (window.pageYOffset >= sticky) {
      navbar.classList.add("sticky");
    } else {
      navbar.classList.remove("sticky");
    }
  }
</script>
<?php  
	require_once('template/footer.php');
?>