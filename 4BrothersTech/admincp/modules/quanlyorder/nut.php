
<div class="row" style="width: 1000px">
	<div class="col-md-4">
		<div class="row" >
			<h3>Show Full Orders</h3>
		</div>
		<div class="row">
			<a class="btn btn-primary" href="modules/quanlyorder/xuly.php?full" role="button">Show Full</a>
			<a class="btn btn-info" style="margin-left: 15px" href='modules/quanlyorder/exportExcel.php?full' target='_blank'>Export Excel Full</a>
		</div>
	</div>
	<div class="col-md-8">
		<div class="row">
			<h3 style="padding-left: 15px">Show by Date</h3>
		</div>
		<form action="modules/quanlyorder/xuly.php" method="get">
			<div class="form-group row">
				<label class="col-sm-2 form-control-label" for="">From </label>
				<div class="col-sm-10">
					<input type="date" name="from" value="<?php echo isset($_GET['date1'])? $_GET['date1'] : '' ?>">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 form-control-label" for="">To</label>
				<div class="col-sm-10">
					<input type="date" name="to" value="<?php echo isset($_GET['date2'])? $_GET['date2'] : '' ?>"> 					
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-offset-2 col-sm-10">
					<input class="btn btn-primary" type="submit" name="filter" id="filter" value="Show by date">	
				</div>
			</div>
		</form>
	</div>
</div>

