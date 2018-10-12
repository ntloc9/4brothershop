

 ?>
<div class="container">

<div class="row" id="intro">
		<?php 
		if (isset($_GET['quanly'])) {
			$tam = $_GET['quanly'];
		}else{
			$tam = '';
		}if ($tam == 'quanlyloaisp') {
			include('modules/quanlyloaisp/main.php');
		}if ($tam == 'quanlysp') {
			include('modules/quanlysp/main.php');
		}if ($tam == 'quanlythongtin') {
			include('modules/quanlythongtin/main.php');
		}if ($tam == 'quanlyorder') {
			include('modules/quanlyorder/main.php');
		}if ($tam == 'quanlyfeedback') {
			include('modules/quanlyfeedback/main.php');
		}if ($tam == 'quanlyreply') {
			include('modules/quanlyreply/main.php');
		}if ($tam =='xuat') {
			include('../logout.php');
		}

	 ?>
	</div>
	
</div>
<div class="clear"></div>