<?php
if(isset($_POST['category']))
{
    require($_SERVER['DOCUMENT_ROOT'].'/4brotherstech/config/const.php');
    require($_SERVER['DOCUMENT_ROOT'].'/4brotherstech/config/db.php');
	$category = $_POST['category'];
	$query = "select * from categories where category = '$category'";
	$result = mysqli_query($conn,$query);
	$category = mysqli_fetch_array($result);
	$category_id = $category['id'];


	$query = "select * from products where category_id = '$category_id' limit 10";
	$result = mysqli_query($conn, $query);
	$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo mysqli_error($conn);
	foreach ($products as $product) {
		echo "<tr>";
		echo "<td>".$product["id"]."</td>";
		echo "<td>".$product["name"]."</td>";
		echo "<td><button type='button' class='btn btn-warning' onclick=\"window.location.href='product-details.php?edit=".$product['id']."'\" >Edit</button></td>";
		echo "<td><button type='button' class='btn btn-danger'onclick=\"window.location.href='product_management.php?delete=".$product['id']."'\" >Delete</button></td>";
		echo "</tr>";
	}

}

?>

