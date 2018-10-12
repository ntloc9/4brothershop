<?php 
	$sql = "select * from feedback";
	$run = mysqli_query($conn,$sql);
 ?>
	<div class="col-lg-12">
		<h1 class="pb-2 mt-4 mb-2 border-bottom">Feedback List</h1>
	</div>
<div id="page-wrapper">
	<div>
		<a style="padding: 10px" class="btn btn-secondary float-right" href="modules/quanlyfeedback/exportExcel.php">Xuất file excel</a> 
	</div>
	<table width="100%" border="1" style="margin-top: 60px;">
	<tr>
		<td>ID</td>
		<td>Title</td>
		<td>Content</td>
		<td>Email</td>
		<td>Name</td>
		<td>Created_day</td>
		<td>Status</td>
		<td colspan="2">Action</td>
		
	</tr>
	<?php 
		while ($dong = mysqli_fetch_array($run)) {
	?>
	<tr>
		<td><?php echo $dong['id']; ?></td>
		<td><?php echo $dong['title']; ?></td>
		<td><?php echo $dong['content']; ?></td>
		<td><?php echo $dong['email']; ?></td>
		<td><?php echo $dong['name']; ?></td>
		<td><?php echo $dong['created_day']; ?></td>
		<td><?php echo $dong['status']; ?></td>
		<td>
		<a class="no-underline" href="index.php?quanly=quanlyfeedback&ac=traloi&id=<?php echo $dong['id']; ?>">	Answer
		</a>
		</td>
		<td><a class="no-underline" href="modules/quanlyfeedback/xuly.php?id= <?php echo $dong['id']; ?>">
		Delete</a></td>
	</tr>
	<?php 
		}
	?>
	
	</table>
</div>