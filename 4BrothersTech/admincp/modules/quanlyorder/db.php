<?php 

$conn = mysqli_connect('localhost', 'root', 'mysql', 'ShopDB');

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_errno());
}

?>