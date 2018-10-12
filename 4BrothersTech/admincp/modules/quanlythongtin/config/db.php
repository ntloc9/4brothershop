<?php 

$conn = mysqli_connect('db_php', 'devuser', 'devpass', 'test_db');

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_errno());
}

?>