<?php 
	require_once('config/const.php');
	require_once('config/db.php');
	require_once('config/function.php');

	unset($_SESSION["user_logged"]);
	unset($_SESSION["user_type"]);
	unset($_SESSION["user_name"]);
	unset_product();
	unset_quantity_and_total();
	header('Location: '.ROOT_URL.'index.php');
?>
