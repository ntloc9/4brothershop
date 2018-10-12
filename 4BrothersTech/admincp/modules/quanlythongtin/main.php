	<?php 
		if (isset($_GET['ac'])) {
			$tam = $_GET['ac'];
		}
		else{
			$tam = '';
		}
		if ($tam == 'them') {
			include('modules/quanlythongtin/them.php');
		}
		if ($tam == 'sua') {
			include('modules/quanlythongtin/sua.php');
		}	
		if ($tam == 'lietke') {
			include('modules/quanlythongtin/lietke.php');
		}

	 ?>
