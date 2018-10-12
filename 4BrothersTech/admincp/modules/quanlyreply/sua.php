<?php 
	$sql = "SELECT * from replies where id = $_GET[id]";
	$run = mysqli_query($conn,$sql);
	$dong = mysqli_fetch_array($run);
 ?>
<form action="modules/quanlyreply/xuly.php?id=<?php echo $dong['id']; ?>" method="post" enctype="multipart/form-data">
	<table width="100%" border="1">
		<tr>
			<td colspan="2"> <div align="center">Edit status</div></td>
		</tr>
		<tr>
			<td>ID</td>
			<td><input type="text" name="id" value="<?php echo $dong['id']; ?>"></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="text" name="password" value="<?php echo $dong['password']; ?>"></td>
		</tr>
		<tr>
			<td>Type</td>
			<td><input type="text" name="type" value="<?php echo $dong['type']; ?>"></td>
		</tr>
		<tr>
			<td colspan="2"> <div align="center"><input type="submit" name="sua" id="sua" value="Edit"></div></td>
		</tr>
	</table>
</form>
