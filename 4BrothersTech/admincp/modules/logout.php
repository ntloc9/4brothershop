<?php 
	require('config/const.php');
	require('config/db.php');
 ?>


<?php

session_start();

unset($_SESSION["user_logged"]);
$_SESSION["user_logged"] = 0;
foreach ($_SESSION as $name => $value) {
        if (substr($name, 0, 8 == "product_")) {
            unset($_SESSION[$name]);
        }
}

unset($_SESSION['item_total']);
unset($_SESSION['item_quantity']);

header('Location: '.ROOT_URL.'home.php');
?>
