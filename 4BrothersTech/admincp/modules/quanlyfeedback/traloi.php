<?php 
	$id = $_GET['id'];
	$query = "select * from feedback";
	$result = mysqli_query($conn,$query);
	$feedback = mysqli_fetch_array($result,MYSQLI_ASSOC);
 ?>
	
<div class="col-lg-12">
	<h1 class="pb-2 mt-4 mb-2 border-bottom">Reply management</h1>
</div>

<form action="modules/quanlyfeedback/xuly.php" method="POST" enctype="multipart/form-data" onsubmit="return alert('Answered');">

	<div id="page-wrapper">

		<div class="col-lg-12">
			<h2 style="display: inline-block;">Answer your feedback</h2>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<label for="email">Feedback_id</label>
				</div>
				<div class="col-md-9">
					<div class="form-group">
						<div class="input-group mb-2 mr-sm-2 mb-sm-0">
							<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
							<?php echo $id; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					<label for="title">Title</label>
				</div>
				<div class="col-md-9">
					<div class="form-group">
						<div class="input-group mb-2 mr-sm-2 mb-sm-0">
							<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
							<input type="text" name="title">
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					<label for="content">Content</label>
				</div>
				<div class="col-md-9">
					<div class="form-group">
						<div class="input-group mb-2 mr-sm-2 mb-sm-0">
							<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-address-card"></i></div>
							<input type="text" name="content">
						</div>
					</div>
				</div>
			</div>	
			<a style="margin-right: 30px;" class="no-underline btn btn-success float-right" href="index.php?quanly=quanlyfeedback&ac=lietke">Feedback List</a> 
			<input class="btn btn-primary" type="submit" name="them" id="them" value="Answer"/>
		</div>
	</div>
</form>


