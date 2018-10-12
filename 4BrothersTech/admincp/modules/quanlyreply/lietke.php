<?php 
	$sql = "SELECT * from replies";
	$run = mysqli_query($conn,$sql);
 ?>
	<div class="col-lg-12">
		<h1 class="pb-2 mt-4 mb-2 border-bottom">Reply List</h1>
	</div>
<div id="page-wrapper">
	<div>
		<a style="padding: 10px" class="btn btn-secondary float-right" href="modules/quanlyreply/exportExcel.php">Xuất file excel</a> 
	</div>
	<table width="100%" border="1" style="margin-top: 60px;">
	<tr>
		<td>ID</td>
		<td>Title</td>
		<td>Content</td>
		<td>Status</td>		
	</tr>
	<?php 
		while ($dong = mysqli_fetch_array($run)) {
	?>
	<tr>
		<td><?php echo $dong['id']; ?></td>
		<td><?php echo $dong['title']; ?></td>
		<td><?php echo $dong['content']; ?></td>
		<td><?php echo $dong['status']; ?></td>
	</tr>
	<?php 
		}
	?>
	
	</table>
</div>