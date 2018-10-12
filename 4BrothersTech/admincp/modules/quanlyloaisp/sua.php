<?php 
	$sql = "select * from categories where id = $_GET[id]";
	$run = mysqli_query($conn,$sql);
	$dong = mysqli_fetch_array($run);
 ?>
<form action="modules/quanlyloaisp/xuly.php?id=<?php echo $dong['id']; ?>" method="post" enctype="multipart/form-data">
	<table width="100%" border="1">
		<tr>
			<td colspan="2"> <div align="center">Edit category name</div></td>
		</tr>
		<tr>
			<td>ID</td>
			<td><input type="text" name="tenloaisp" value="<?php echo $dong['id']; ?>" disabled></td>
		</tr>
		<tr>
			<td>Category</td>
			<td><input type="text" name="tenloaisp" value="<?php echo $dong['category']; ?>"></td>
		</tr>
		<tr>
			<td colspan="2"> <div align="center"><input type="submit" name="sua" id="sua" value="Edit"></div></td>
		</tr>
	</table>
</form>
