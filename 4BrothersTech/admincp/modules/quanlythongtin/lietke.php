<?php 
	$sql = "select * from users";
	$run = mysqli_query($conn,$sql);
 ?>
	<div class="col-lg-12">
		<h1 class="pb-2 mt-4 mb-2 border-bottom">List of Account</h1>
	</div>
<div id="page-wrapper">
	<div>
		<a style="padding: 10px" class="btn btn-success float-left" href="index.php?quanly=quanlythongtin&ac=them">Thêm Mới</a>
		<a style="padding: 10px" class="btn btn-secondary float-right" href="modules/quanlythongtin/exportExcel.php">Xuất file excel</a> 
	</div>
	<table width="100%" border="1" style="margin-top: 60px;">
	<tr>
		<td>ID</td>
		<td>Email</td>
		<td>Password</td>
		<td>Address</td>
		<td>Birthday</td>
		<td>Name</td>
		<td>Phone</td>
		<td>Type</td>
		<td colspan="2">Action</td>
		
	</tr>
	<?php 
		while ($dong = mysqli_fetch_array($run)) {
	?>
	<tr>
		<td><?php echo $dong['id']; ?></td>
		<td><?php echo $dong['email']; ?></td>
		<td><?php echo $dong['password']; ?></td>
		<td><?php echo $dong['address']; ?></td>
		<td><?php echo $dong['birthday']; ?></td>
		<td><?php echo $dong['name']; ?></td>
		<td><?php echo $dong['phone']; ?></td>
		<td><?php echo $dong['type']; ?></td>
		<td><a class="no-underline" href="index.php?quanly=quanlythongtin&ac=sua&id=<?php echo $dong['id']; ?>">Edit</a></td>
		<td><a class="no-underline" href="modules/quanlythongtin/xuly.php?id= <?php echo $dong['id']; ?>">Delete</a></td>
	</tr>
	<?php 
		}
	?>
	
	</table>
</div>