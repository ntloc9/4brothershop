<?php 
require_once('config/const.php');
require_once('config/db.php');
require_once('config/function.php');
require_once('template/header.php');
require_once('template/nav.php');

$date =  date('Y-m-d H:i:s');
$created_day = date('Y-m-d H:i:s', strtotime($date));  
if(isset($_POST['submit'])) {
	$user_id = $_SESSION["user_logged"];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$title = $_POST['title'];
	$content = $_POST['content'];	
	$product_id = $_POST['product_id'];
	$query = "INSERT into feedback(user_id,title,content,email,name,product_id,created_day) 
	VALUES('$user_id','$title','$content','$email','$name','$product_id','$created_day')";
	confirm(mysqli_query($conn,$query));
	redirect("product-detail.php?id=".$product_id);
} elseif(isset($_GET["id"])) {
	$product_id = $_GET["id"];
	$query = "select * from products where id = $product_id limit 1";
	$result = mysqli_query($conn,$query);
	$product = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$hideDiscount = FALSE;
	if(!$product["discount_price"]) 
		$hideDiscount = TRUE;
}

?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/product_detail.css" rel="stylesheet">
	<script>
		$('#image_rotate').cycle({
			random: 1
		});
		// Open the Modal
		function openModal() {
			document.getElementById('myModal').style.display = "block";
			document.getElementById('navbar').style.display = "none";
			document.getElementById('btn-search').style.display = "none";
		}

		// Close the Modal
		function closeModal() {
			document.getElementById('myModal').style.display = "none";
			document.getElementById('navbar').style.display = "block";
			document.getElementById('btn-search').style.display = "block";
		}

		var slideIndex = 0;
		

		// Next/previous controls
		function plusSlides(n) {
			showSlides(slideIndex += n);
		}

		// Thumbnail image controls
		function currentSlide(n) {
			showSlides(slideIndex = n);
		}

		function showSlides(n) {
			var i;
			var slides = document.getElementsByClassName("mySlides");

			if (n == slides.length) {
				slideIndex = 0
			} 
			if (n < 0) {
				slideIndex = slides.length-1
			}
			for (i = 0; i < slides.length; i++) {
				slides[i].style.display = "none";
			}
			slides[slideIndex].style.display = "block";
		}
	</script>

	<title><?php echo $product["name"]; ?></title>
	<style>

</style>
</head>
<body>
	<div class="container-fluid" style="background-color: white;border-radius:5px">
		<div class="row">
			<div class="col-md-6">
				<?php 
				$files = glob("image/$product_id/*.*");
				if(!count($files))
					$files[0] = 'template/noimage.jpg';

				echo "<a class='active' data-target=\"#pic-1\" data-toggle=\"tab\"><img src=\"".$files[0]."\"  onclick=\"openModal();currentSlide(0)\" class='hover-shadow active' /></a>";
				for ($i=1; $i<count($files); $i++)
				{
					$num = $files[$i];
					echo '<div class="column">';
					echo "<img src=\"".$num."\"  onclick=\"openModal();currentSlide(".($i).")\" class=\"hover-shadow\" width='100px' height='100px'/>";
					echo '</div>';
				}
				?>

				<div id="myModal" class="modal">
					<span class="close cursor" onclick="closeModal()">&times;</span>
					<div class="modal-content">
						<?php 
						for ($i=0; $i<count($files); $i++)
						{
							$num = $files[$i];
							echo '<div class="mySlides">';
							echo "<img src=\"".$num."\" style=\"height:600px;max-width:100%\"  />";
							echo '</div>';
						}
						?>
						<!-- Next/previous controls -->
						<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
						<a class="next" onclick="plusSlides(1)">&#10095;</a>

					</div>
				</div>
			</div>
			<div class="col-md-6">
				<h4 class="product-title"><?php echo $product["name"]; ?></h4>
				<p class="price <?php if($hideDiscount) echo "invisible"; ?>" id='discount' >Discount price: <span><?php echo $product["discount_price"]; ?>$</span></p>
				<h5 class="price">Price: <span><?php echo $product["price"]; ?>$</span></h5><br>
				<div class="row">
					<div class="action">
						<button class=" btn btn-primary" type="button" onclick="window.location.href='cart.php?add=<?php echo $product_id;?>'"><span class='fa fa-shopping-cart'> Add to Cart</span></button>
						<button <?php if(!isset($_SESSION["user_logged"])) echo "disabled"; ?> class='btn btn-danger' type='button' onclick="window.location.href='wishlist.php?add=<?php echo $product_id;?>'"><span class='fa fa-heart'> Add to Wishlist</span></button>
					</div>				
				</div>	
				<div class="row">
				</div>
				<div class="row">
					<div class="product_rassurance">
						<ul class="list-inline">
							<li class="list-inline-item"><i class="fa fa-truck fa-2x"></i><br/>Fast delivery</li>
							<li class="list-inline-item"><i class="fa fa-credit-card fa-2x"></i><br/>Secure payment</li>
							<li class="list-inline-item"><i class="fa fa-phone fa-2x"></i><br/>+84 1800 6975 </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-2"></div>
			<div class="col-8">
				<div class="card border-light mb-3">
					<div class="card-header bg-primary text-white text-uppercase"  style="background-color: #b1b362 !important;text-align: center" > PRODUCT SPECIFICATIONS</span></div>
					<table class="table table-hover">
						<tbody>
							<tr>
								<td>Branch</td>
								<td><?php 
								$branch = mysqli_fetch_array(mysqli_query($conn,"select * from product_branch where id = ".$product["branch_id"]." limit 1"),MYSQLI_ASSOC);
								echo $branch["branch"];
								?></td>
							</tr>
							<tr>
								<td>Warranty</td>
								<td><?php 
								echo $product["warranty"]." months";
								?></td>
							</tr>
							<tr>
								<td>Category</td>
								<td><?php 
								$category = mysqli_fetch_array(mysqli_query($conn,"select * from categories where id = ".$product["category_id"]." limit 1"),MYSQLI_ASSOC);
								echo $category["category"];
								?></td>
							</tr>
							<tr>
								<td>Subcategory</td>
								<td><?php 
								$subcategory = mysqli_fetch_array(mysqli_query($conn,"select * from subcategories where id = ".$product["subcategory_id"]." limit 1"),MYSQLI_ASSOC);
								echo $subcategory["subcategory"];
								?></td>
							</tr>
							<?php 
							$query = "SELECT  t1.attribute, t2.attribute_value FROM attributes t1 , product_attributes t2 where t1.id  =  t2.attribute_id AND t2.product_id = ".$product["id"]."";
							$attributes = mysqli_fetch_all(mysqli_query($conn,$query), MYSQLI_ASSOC);
							foreach ($attributes as $attribute) {
								echo "<tr>";
								echo "<td>".$attribute["attribute"]."</td>";
								echo "<td>".$attribute["attribute_value"]."</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-2"></div>
		</div>
		<div class="col-12">
			<div class="card-header bg-primary text-white text-uppercase" > PRODUCT DESCRIPTION</div>
			<div class="card-body">
				<?php echo $product["description"]; ?>
			</div>
		</div>
		<!-- viết bình luận -->
		<!-- <div class="col-12">
			<div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-align-justify"></i> WRITE FEEDBACK</div>
			<div class="card-body">
				<?php 
				$result = 0;
				if (isset($_SESSION['user_logged'])) {
					$query = "SELECT count(*) from order_items oi , orders os 
					where oi.product_id = $product_id AND oi.order_id = os.id and os.user_id = ".$_SESSION['user_logged']; 
					$dong = mysqli_query($conn,$query);
					$result = mysqli_num_rows($dong);
				}

				?>
				<?php if ($result): ?>
					<div class="row">
						<div class="col-6">
							<form action="product-detail.php" method="POST" 
							onsubmit="return alert('Thanks for feedback');">
							<input class="invisible" type="number" name="product_id" value="<?php echo $product_id; ?>">
							<div class="form-group">
								<label for="name">1.Name</label>
								<input type="text" name="name" required="ON" 
								value="<?php echo $_SESSION['user_name'];?>">
							</div>
							<div class="form-group">
								<label for="email">2.Email</label>
								<input type="email" name="email" required="ON" 
								value="<?php echo $_SESSION['user_email'];?>">
							</div>
							<div class="form-group">
								<label for="title">2.Title</label>
								<input type="text" name="title" required="ON">
							</div>
							<div class="form-group">
								<label for="content">3.Content</label>
								<textarea name="content" id="" cols="30" rows="10" required="ON">

								</textarea>
							</div>
							<div class="form-group">
								<input type="submit" name="submit" value="Send feedback">
							</div>
						</form>

					</div>
					<div class="col-6">
						<?php 
						$files = glob("image/$product_id/*.*");
						if(!count($files))
							$files[0] = 'template/noimage.jpg';

						echo "<a class='active' data-target=\"#pic-1\" data-toggle=\"tab\"><img src=\"".$files[0]."\"  width='150px' height='150px' /></a>";

						?>
						<span><?php echo $product["name"]; ?></span>
						<div class="card-body">
							<p>Customers are questions of the product or the company service? Customers are currently want to be denied or comment about purchase items?</p>

							<ul>
								<li>Reference references information at Support information.</li>
								<li>Hotline: Hotline : (+84) 933 9898 81 or send email to kinhdoanh@gearvn.com  </li>
							</ul>
						</div>
					</div>
				</div>

			<?php endif ?>
		</div>

	</div>
	<div class="col-12">
		<div class="card border-light mb-3">
			<div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-align-justify"></i> REVIEWS
			</div>
			<div class="review-block">

				<?php 
				$product_id = $_GET["id"];
				$query = "SELECT * FROM feedback where product_id =  $product_id";
				$result = mysqli_query($conn,$query); 
				while ($dong = mysqli_fetch_assoc($result)) {
					?>
					<div class="row" style="border-bottom: solid">
						<div class="col-sm-3">
							<img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">
							<div class="review-block-name"><a href="#"><?php echo $dong['name']; ?></a></div>
							<div class="review-block-date"><?php echo $dong['created_day']; ?>
							<br/></div>
						</div>
						<div class="col-sm-9">
							<div class="review-block-rate">
								<button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
									<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
								</button>
								<button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
									<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
								</button>
								<button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
									<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
								</button>
								<button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
									<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
								</button>
								<button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
									<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
								</button>
							</div>
							<div class="review-block-title"><?php echo $dong['title']; ?></div>
							<div class="review-block-description"><?php echo $dong['content']; ?></div>
						</div>

					</div>
					<?php 
				}
				?>

			</div>
		</div>

		
	</div> -->
	<div class="col-12">
		<div class="card border-light mb-3">
			<div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-align-justify"></i> Products you may also like</div>

			<?php 
			$category_id = $product["category_id"];
			showProductbyCategory($category_id);

			?>

		</div>
	</div>
	<div class="col-12">
		<div class="card border-light mb-3">
			<div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-align-justify"></i>  Same manufacturer</div>

			<?php 
			$branch_id = $product["branch_id"];
			showProductbyBranch($branch_id);
			?>

		</div>
	</div>
</div>


<?php require_once('template/footer.php'); ?>
</body >
</html>

