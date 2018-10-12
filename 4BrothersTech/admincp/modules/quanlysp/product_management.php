<?php 
    require($_SERVER['DOCUMENT_ROOT'].'/4brotherstech/config/const.php');
    require($_SERVER['DOCUMENT_ROOT'].'/4brotherstech/config/db.php');
    
	if(isset($_GET['delete'])){
		$product_id = $_GET['delete'];
		$query = "delete from product_attributes where product_id = $product_id";
		mysqli_query($conn, $query);
		$query = "delete from products where id = $product_id";
		mysqli_query($conn, $query);
	}
 ?>
<script type="text/javascript">
	function fetch_select(val)
	{
		$.ajax({
			type: 'post',
			url: 'fetch_product.php',
			data: {
				category:val
			},
			success: function (response) {
				document.getElementById("list").innerHTML=response; 
			}
		});
	}	
</script>

<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
			<label for="category">Category:</label>
			<select class="custom-select custom-select-md" name="category" onchange="fetch_select(this.value);" >
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
		
		<table class="table table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Details</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody id="list">

			</tbody>
		</table>

	</div>
</div>