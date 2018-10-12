<?php 
	$sql = "select * from categories";
	$run = mysqli_query($conn,$sql);
 ?>
<table width="100%">
	<tr>
		<td>ID</td>
		<td>Category</td>
		<td colspan="2">Action</td>
		
	</tr>
	<?php 
		while ($dong = mysqli_fetch_array($run)) {
	 ?>
	<tr>
		<td><?php echo $dong['id']; ?></td>
		<td><?php echo $dong['category']; ?></td>
		<td><a href="index.php?quanly=quanlyloaisp&ac=sua&id=<?php echo $dong['id']; ?>">Change</a></td>
		<td><a href="modules/quanlyloaisp/xuly.php?id= <?php echo $dong['id']; ?>">Delete</a></td>
	</tr>
	<?php 
		}
	 ?>
	
</table>