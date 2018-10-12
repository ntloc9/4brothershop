
	
<div class="col-lg-12">
	<h1 class="pb-2 mt-4 mb-2 border-bottom">Customer Management</h1>
</div>

<form action="modules/quanlythongtin/xuly.php" method="post" enctype="multipart/form-data">

<div id="page-wrapper">

	<div class="col-lg-12">
		<h2 style="display: inline-block;">Add new account</h2>
	</div>

	<div class="container">
	<div class="row">
		<div class="col-md-3">
			<label for="email">Email</label>
		</div>
		<div class="col-md-9">
			<div class="form-group">
				<div class="input-group mb-2 mr-sm-2 mb-sm-0">
					<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
					<input type="text" name="email">
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<label for="password">Password</label>
		</div>
		<div class="col-md-9">
			<div class="form-group">
				<div class="input-group mb-2 mr-sm-2 mb-sm-0">
					<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
					<input type="text" name="password">
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<label>Address</label>
		</div>
		<div class="col-md-9">
			<div class="form-group">
				<div class="input-group mb-2 mr-sm-2 mb-sm-0">
					<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-address-card"></i></div>
					<input type="text" name="address">
				</div>
			</div>
		</div>
	</div>
		
	<div class="row">
		<div class="col-md-3">
			<label>Birthday</label>
		</div>
		<div class="col-md-9">
			<div class="form-group">
				<div class="input-group mb-2 mr-sm-2 mb-sm-0">
					<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-birthday-cake"></i></div>
					<input type="date" name="birthday">
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<label>Name</label>
		</div>
		<div class="col-md-9">
			<div class="form-group">
				<div class="input-group mb-2 mr-sm-2 mb-sm-0">
					<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
					<input type="text" name="name">
				</div>
			</div>
		</div>
	</div>
		
	<div class="row">
		<div class="col-md-3">
			<label>Phone</label>
		</div>
		<div class="col-md-9">
			<div class="form-group">
				<div class="input-group mb-2 mr-sm-2 mb-sm-0">
					<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-phone"></i></div>
					<input type="text" name="phone">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<label>Type</label>
		</div>
		<div class="col-md-9">
			<div class="form-group">
				<div class="input-group mb-2 mr-sm-2 mb-sm-0">
					<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
					<input type="text" name="type">
				</div>
			</div>
		</div>
	</div>
	<a style="margin-right: 30px;" class="no-underline btn btn-success float-right" href="index.php?quanly=quanlythongtin&ac=lietke">List of account</a> 
	<input class="btn btn-primary" type="submit" name="them" id="them" value="Add">
</div>
</div>
</form>


