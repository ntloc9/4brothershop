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
	</script>

<title>Input product information</title>

</head>
<body onload="fetch_select('CASE');">
	<?php 

    checkadmin();
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
		$subcategory = $_POST["subcategory"] ;
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
			//insert into products table
			$query = "INSERT INTO products (name, description, category_id, subcategory_id, stock, unit, price, discount_price,warranty, branch_id) 
			VALUES ('$name','$description','$category_id','$subcategory_id','$stock','$unit', '$price','$discount_price +0','$warranty','$branch_id')";
		    if(	!mysqli_query($conn,$query))
		        echo mysqli_error($conn);
			$product_id =  mysqli_insert_id($conn);

			//get attributes id, value
			$query = "select * from attributes where category_id = '$category_id'";
			$result = mysqli_query($conn,$query);
			$attributes = mysqli_fetch_all($result, MYSQLI_ASSOC);
			
			//create folder named by product id
			mkdir($_SERVER['DOCUMENT_ROOT']."/4brotherstech/Image/".$product_id); 
			include ($_SERVER['DOCUMENT_ROOT']."/4brotherstech/admincp/modules/quanlysp/upload.php");

			//insert into product_attributes table
			$attributes_id = array();
			foreach ($attributes as $attribute) {
				array_push($attributes_id,$attribute['id']);
			}
			$attributes_values = $_POST["attributes_values"];
			$attributes = array_combine($attributes_id,	$attributes_values);
			$values = ' VALUES ';
			foreach ($attributes as $key => $value) {
				$values .= "('$product_id','$key','$value'),";
			}
			$values = substr($values, 0, -1);
			$query = "INSERT INTO product_attributes (product_id, attribute_id, attribute_value) $values";
			mysqli_query($conn,$query);
		}
	}
	?>
	<form method="POST" enctype="multipart/form-data">
		<div class="rows">
			<?php require($_SERVER['DOCUMENT_ROOT'].'/4brotherstech/admincp/modules/menu.php'); ?>
		<div class="container-fluid">
			<div class="row" >
				
				<div class="col-md-8"><h2>GENERAL </h2></div>
				<div class="col-md-4"><h2>DETAILS </h2></div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="name">Name:</label><span id="error"><?php echo $nameError; ?></span> 
						<input type="text" class="form-control" name="name" id="name"  value="<?php echo $name; ?>">
					</div> 
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="category">Category:</label>
						<select class="custom-select custom-select-md" name="category" onchange="fetch_select(this.value);" >
							<?php 
							$query = "select * from categories";
							$result = mysqli_query($conn, $query);
							$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
							mysqli_free_result($result);
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
								<input type="number" class="form-control" name="stock" value="<?php echo $stock; ?>">
							</div> 
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="price">Price:</label><span id="error"><?php echo $priceError; ?></span> 
								<input type="number" class="form-control" name="price" value="<?php echo $price; ?>" >
							</div> 
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="discount_price">Discount Price:</label>
								<input type="number" class="form-control" name="discount_price" value="<?php echo $discount_price; ?>">
							</div> 
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="unit">Unit:</label><span id="error"><?php echo $unitError; ?></span> 
								<select class="form-control" name="unit">
									<?php enumDropdown('products', 'unit', TRUE); ?>
								</select>
							</div> 
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="warranty">Warranty:</label><span id="error"><?php echo $warrantyError; ?></span> 
								<input type="number" class="form-control" name="warranty" value="<?php echo $warranty; ?>" >
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
								<textarea class="form-control" rows="10" name="description"><?php echo htmlspecialchars($description); ?></textarea>
								<a target="_blank" style="margin-left:85%" class="btn btn-info" href="https://html-online.com/editor/"> Using Editor</a>
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
		</div>
	</div>
	</form>
</body>
</html>