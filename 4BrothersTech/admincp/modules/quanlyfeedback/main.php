<div class="row" style="width: 1000px">
	<div class="col-md-4">
		<div class="row" >
			<h3>Show Full Orders</h3>
		</div>
		<div class="row">
			<a class="btn btn-primary" href="modules/quanlyfeedback/xuly.php?full" role="button">Show Full</a>
		</div>
	</div>
	<div class="col-md-8">

		<div class="row">
			<h3 style="padding-left: 15px">Show by Date</h3>
		</div>
		<form action="modules/quanlyfeedback/xuly.php" method="get">
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
	<?php 
		if (isset($_GET['ac'])) {
			$tam = $_GET['ac'];
		}
		else{
			$tam = '';
		}
		if ($tam == 'traloi') {
			include('modules/quanlyfeedback/traloi.php');
		}
		if ($tam == 'lietke') {
			include('modules/quanlyfeedback/lietke.php');
		}if ($tam == 'ngay') {
			$date1 = mysqli_real_escape_string($conn, $_GET['date1']);
			$date2 = mysqli_real_escape_string($conn, $_GET['date2']);

			// header("Location:../../test.php?date1=" . $date1 . "&date2=" . $date2);
			echo "<table width='100%'' border='0'>";
			echo "<tr>";
			echo "<td>ID</td>";
			echo "<td>Title</td>";
			echo "<td>Content</td>";
			echo "<td>Email</td>";
			echo "<td>Name</td>";
			echo "<td>Created_day</td>";
			echo "<td>Status</td>";
			echo "</tr>";
			filter($date1,$date2); //gọi hàm lấy order theo ngày
			echo "</table>";
		}if ($tam == 'full') {
			echo "<table width='100%'' border='0'>";
			echo "<tr>";
			echo "<td>ID</td>";
			echo "<td>Title</td>";
			echo "<td>Content</td>";
			echo "<td>Email</td>";
			echo "<td>Name</td>";
			echo "<td>Created_day</td>";
			echo "<td>Status</td>";
			echo "</tr>";
			full();   //gọi hàm lấy full order
			echo "</table>";
		}

		function filter($d1, $d2){
		global $conn;
		$date1 = mysqli_real_escape_string($conn, $d1);

		$date2 = mysqli_real_escape_string($conn, $d2);

		$query_full = "select * from feedback where created_day between '$date1' and '$date2' ";

		$result = mysqli_query($conn, $query_full);
		// confirm($result);
		$feedbacks = mysqli_fetch_all($result, MYSQLI_ASSOC);

		foreach ($feedbacks as $feedback) {

			$user_id = $feedback['user_id'];
			$query_grab_user_name = "select * from feedback";
			$query_user_name = mysqli_query($conn, $query_grab_user_name);
			$user_name = mysqli_fetch_array($query_user_name);

			//sửa lại ngày y/m/d thành d/m/y
			$dateShow = formatDate($feedback['created_day']);	
			
			$showorder = <<<DELIMETER

			<tr>
			<td>{$feedback['id']}</td>
			<td>{$user_name['title']}</td>
			<td>{$user_name['content']}</td>
			<td>{$user_name['email']}</td>
			<td>{$user_name['name']}</td>
			<td>{$dateShow}</td>
			<td>{$order['status']}</td>
			</tr>

DELIMETER;
		echo $showorder;

		}	
	}
	function full(){
		global $conn;
		$query_full = "select * from feedback";
		$result = mysqli_query($conn, $query_full);
		// confirm($result);
		$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

		$result = mysqli_query($conn, $query_full);
		// confirm($result);
		$feedbacks = mysqli_fetch_all($result, MYSQLI_ASSOC);

		foreach ($feedbacks as $feedback) {

			$user_id = $feedback['user_id'];
			$query_grab_user_name = "select * from users";
			$query_user_name = mysqli_query($conn, $query_grab_user_name);
			$user_name = mysqli_fetch_array($query_user_name);

			//sửa lại ngày y/m/d thành d/m/y
			$dateShow = formatDate($feedback['created_day']);	
			
			$showorder = <<<DELIMETER

			<tr>
			<td>{$feedback['id']}</td>
			<td>{$feedback['title']}</td>
			<td>{$feedback['content']}</td>
			<td>{$feedback['email']}</td>
			<td>{$user_name['name']}</td>
			<td>{$dateShow}</td>
			<td>{$feedback['status']}</td>
			</tr>

DELIMETER;
		echo $showorder;

		}	
		// echo '<nav aria-label="Page navigation example"><ul class="pagination">';
		echo $Parr['output'];
	    // echo '</ul></nav>';
	}

	 ?>
