<?php 

$conn = mysqli_connect('localhost', 'root', 'mysql', 'shopdb');

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_errno());
}

?>