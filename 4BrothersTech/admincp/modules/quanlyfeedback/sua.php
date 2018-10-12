<?php 
	$sql = "SELECT * from feedback where id = $_GET[id]";
	$run = mysqli_query($conn,$sql);
	$dong = mysqli_fetch_array($run);
 ?>
<form action="modules/quanlyfeedback/xuly.php?id=<?php echo $dong['id']; ?>" method="post" enctype="multipart/form-data">
	<table width="100%" border="1">
		<tr>
			<td colspan="2"> <div align="center">Answer</div></td>
		</tr>
		<tr>
			<td>ID</td>
			<td><input type="text" name="id" value="<?php echo $dong['id']; ?>"></td>
		</tr>
		<tr>
			<td>Title</td>
			<td><input type="text" name="title"></td>
		</tr>
		<tr>
			<td>Content</td>
			<td><input type="text" name="content"></td>
		</tr>
		<tr>
			<td colspan="2"> <div align="center"><input type="submit" name="sua" id="sua" value="Answer">
			</div></td>
		</tr>
	</table>
</form>
