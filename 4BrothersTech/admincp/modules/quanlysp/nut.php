
<!-- <button onclick="location.href='modules/quanlysp/xuly.php?full'" type="button">
    Showfull</button>

<button onclick="location.href='modules/quanlysp/newproduct.php'" type="button">
    Create new</button>
 -->
 <form action="modules/quanlysp/xuly.php" method="get">
<h4>View Transactions</h4>
<div class="row">
		
		<div class="col-md-">
			<label for="">From</label>
			<input type="date" name="from" value="<?php echo isset($_GET['date1'])? $_GET['date1'] : '' ?>"> <br>
			<label for="">To  </label>
			<input type="date" name="to" value="<?php echo isset($_GET['date2'])? $_GET['date2'] : '' ?>"> <br>
			<input type="submit" name="filter" id="filter" value="View transactions by date"><br>
			<!-- <button onclick="window.location.href='modules/quanlysp/xuly.php?full'">View all transactions</button> -->
			<a style="padding: 10px" class="btn btn-secondary float-right" href="modules/quanlysp/xuly.php?full">Export all item transactions</a> 
			<!-- <button onlick= href="modules/quanlysp/xuly.php?full">View all transactions</a>  -->
		</div>	
		<!-- <a style="padding: 10px" class="btn btn-secondary float-right" href="modules/quanlythongtin/exportExcel.php">Stock Position Report</a>  -->
</div>

</form>