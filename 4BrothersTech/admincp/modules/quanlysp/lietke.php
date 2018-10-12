


<?php 
	$sql = "select * from products";
	$run = mysqli_query($conn,$sql);
 ?>
	<div class="col-lg-12">
		<h1 class="pb-2 mt-4 mb-2 border-bottom">Product Management</h1>
	</div>
<div id="page-wrapper">
	<div>
		<a style="padding: 10px" class="btn btn-success float-left" href="index.php?quanly=quanlysp&ac=them">New Product</a>
		

	</div>
	<table width="100%" border="1" style="margin-top: 60px;">
	<tr>
		<td>ID</td>
		<td>Name</td>
		<td colspan="2">Action</td>
		
	</tr>
	<?php 
		while ($dong = mysqli_fetch_array($run)) {
	?>
	<tr>
		<td><?php echo $dong['id']; ?></td>
		<td><?php echo $dong['name']; ?></td>
		
		<td><a class="no-underline" href="index.php?quanly=quanlysp&ac=sua&id=<?php echo $dong['id']; ?>">Update Info</a></td>
		<td><a class="no-underline" href="modules/quanlysp/xuly.php?id= <?php echo $dong['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a></td>

	</tr>

	<?php 
		}
	?>
	
	</table>
</div>