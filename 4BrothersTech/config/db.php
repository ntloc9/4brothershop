<?php 
ob_start();
session_start();
$conn = mysqli_connect('localhost', 'root', 'mysql', 'ShopDB');

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_errno());
}

?>