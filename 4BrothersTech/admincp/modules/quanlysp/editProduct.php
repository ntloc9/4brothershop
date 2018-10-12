<?php 

	if(isset($_GET["id"])){
		$product_id = $_GET["id"];
		$product = mysqli_fetch_array(mysqli_query($conn,"select * from products where id = '$product_id'"));

		$branch = mysqli_fetch_array(mysqli_query($conn, "select * from product_branch where id = ".$product["branch_id"].""), MYSQLI_ASSOC);
		$branch_name = $branch["branch"];

		$category = mysqli_fetch_array(mysqli_query($conn, "select * from categories where id = ".$product["category_id"].""), MYSQLI_ASSOC);
		$category_name = $category["category"];

		$subcategory = mysqli_fetch_array(mysqli_query($conn, "select * from subcategories where id = ".$product["subcategory_id"].""), MYSQLI_ASSOC);
		$subcategory_name = $subcategory["subcategory"];
	}
		//Hàm kiểm tra giá trị nhập
	$warrantyError =$nameError = $stockError = $unitError = $priceError = "\t";
	
	$description = null;
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$name =  mysqli_real_escape_string($conn,$_POST['name']);
		$category = $_POST["category"];	
		$description =  mysqli_real_escape_string($conn,$_POST["description"]);
		$stock = $_POST["stock"];
		$unit = $_POST["unit"];
		$price = $_POST["price"];
		$discount_price = $_POST["discount_price"];
		$subcategory = $_POST["subcategory"];
		$warranty = $_POST["warranty"];
		$branch = $_POST["branch"];

		//get branch id
		$query = "select * from product_branch where branch = '$branch'";
		$result = mysqli_query($conn,$query);
		$branchs = mysqli_fetch_array($result);
		$branch_id = $branchs['id'];

		//get category id
		$query = "select * from categories where category = '$category'";
		$result = mysqli_query($conn,$query);
		$category = mysqli_fetch_array($result);
		$category_id = $category['id'];

		//get subcategory id
		$query = "select * from subcategories where subcategory= '$subcategory' && category_id = '$category_id'";
		$result = mysqli_query($conn,$query);
		$subcategory = mysqli_fetch_array($result);
		$subcategory_id = $subcategory['id'];
		
		if(validation_product()){
			//edit record
			$query = "UPDATE products SET name='$name', description = '$description', category_id = '$category_id', stock = '$stock', unit = '$unit', price = '$price', discount_price = '$discount_price', warranty = '$warranty', branch_id = '$branch_id' WHERE id = '$product_id'";
			if(	!mysqli_query($conn,$query))
		        echo mysqli_error($conn);

			//get attributes id, value
			$query = "select * from attributes where category_id = '$category_id'";
			$result = mysqli_query($conn,$query);
			$attributes = mysqli_fetch_all($result, MYSQLI_ASSOC);
			
			//upload new images
			if($_FILES["files"])
				include "upload.php";

			//delete old attribute data
			//mysqli_query($conn,"DELETE from product_attributes where product_id = '$product_id'");

			//insert into product_attributes table
			$attributes_id = array();
			foreach ($attributes as $attribute) {
				array_push($attributes_id,$attribute['id']);
			}

			$attributes_values = $_POST["attributes_values"];
			$attributes = array_combine($attributes_id,	$attributes_values);
			//$values = ' VALUES ';
			foreach ($attributes as $key => $value) {
				$query = "update product_attributes set attribute_value = '$value' where $attribute_id = '$key' and $product_id = '$product_id'";
				confirm(mysqli_query($conn,$query));
			}
		}
	}
	?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> 
	<!-- Custom CSS -->
	<link rel="stylesheet" href="product.css">	

	<script type="text/javascript">
		function fetch_select(val)
		{
			$.ajax({
				type: 'post',
				url: 'modules/quanlysp/fetch_select.php',
				data: {
					category:val
				},
				success: function (response) {
					document.getElementById("sub-select").innerHTML=response; 
				}
			});
		}

		function fetch_id(val)
		{
			$.ajax({
				type: 'post',
				url: 'modules/quanlysp/fetch_select.php',
				data: {
					id:val
				},
				success: function (response) {
					document.getElementById("sub-select").innerHTML=response; 
				}
			});
		}	

	</script>

	<style type="text/css">
		h2 {
			font-weight: bold;
			text-align: center;
		}
	</style>
<body onload="fetch_id('<?php echo $product_id; ?>');">
	<div class="rows">
			<?php require($_SERVER['DOCUMENT_ROOT'].'/4brotherstech/admincp/modules/menu.php'); ?>
		<div class="container-fluid">
			<div class="row" >
				<div class="col-md-8"><h2 >GENERAL </h2></div>
				<div class="col-md-4"><h2>DETAILS </h2></div>
			</div>
			<form action="editProduct.php" method="POST">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="name">Name:</label><span id="error"><?php echo $nameError; ?></span> 
						<input type="text" class="form-control" name="name" id="name"  value="<?php echo $product["name"]; ?>">
					</div> 
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="category">Category:</label>
						<select class="custom-select custom-select-md" name="category" onchange="fetch_select(this.value);" >
							<option selected="selected" style='color:red'><?php echo $category_name;?></option>
							<?php 
							$query = "select * from categories";
							$result = mysqli_query($conn, $query);
							$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
							foreach ($categories as $category) {
								echo '<option>'.$category['category'].'</option>';
							}
							?>
						</select>
					</div> 
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="branch">Manufacturer:</label>
								<select class="custom-select custom-select-md" name="branch" >
									 <option selected="selected" style='color:red'><?php echo $branch_name;?></option> 
									<?php
									$query = "select * from product_branch";
									$result = mysqli_query($conn, $query);
									$branches = mysqli_fetch_all($result, MYSQLI_ASSOC);
									foreach ($branches as $branch) {
										echo '<option>'.$branch['branch'].'</option>';
									}
									?>
								</select>
							</div> 
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="stock">Stock:</label><span id="error"><?php echo $stockError; ?></span> 
								<input type="number" class="form-control" name="stock" value="<?php echo $product["stock"]; ?>">
							</div> 
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="price">Price:</label><span id="error"><?php echo $priceError; ?></span> 
								<input type="number" class="form-control" name="price" value="<?php echo $product["price"]; ?>" >
							</div> 
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="discount_price">Discount Price:</label>
								<input type="number" class="form-control" name="discount_price" value="<?php echo $product["discount_price"]; ?>">
							</div> 
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="unit">Unit:</label><span id="error"><?php echo $unitError; ?></span> 
								
								<select class="form-control" name="unit">
									<option selected="selected" style='color:red'><?php echo $product["unit"]; ?></option>
									<?php enumDropdown('products', 'unit', TRUE); ?>
								</select>
							</div> 
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="warranty">Warranty:</label><span id="error"><?php echo $warrantyError; ?></span> 
								<input type="number" class="form-control" name="warranty" value="<?php echo $product["warranty"]; ?>" >
							</div> 
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="image">Select images to upload:</label>
								<div class="custom-file" >
									<label class="custom-file-label"></label>
									<input type="file" class="custom-file-input" value="0 file(s) selected" name="files[]" multiple > 
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="description">Description:</label>
								<textarea class="form-control" rows="10"  id="description" name="description"><?php echo htmlspecialchars($product["description"]); ?></textarea>
								<!-- <a target="_blank" style="margin-left:85%" class="btn btn-info" href="https://html-online.com/editor/" onclick="copyCon();"> Using Editor</a> -->
							</div> 
						</div>
						<div class="col-md-12" align="center">
							<button type="submit" class="btn btn-primary ">Save</button>
							<button type="reset" class="btn btn-primary ">Cancel</button>
							
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div id='sub-select'>
					</div>
				</div>
			</div>
		</form>
		</div>
	</div>
	</form>
</body>
</html>