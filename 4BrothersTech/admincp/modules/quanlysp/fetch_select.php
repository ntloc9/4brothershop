<?php
require($_SERVER['DOCUMENT_ROOT'].'/4brotherstech/config/db.php');
require($_SERVER['DOCUMENT_ROOT'].'/4brotherstech/config/const.php');
require($_SERVER['DOCUMENT_ROOT'].'/4brotherstech/config/function.php');
if(isset($_POST['category']))
{
	$category = $_POST['category'];
	$query = "select * from categories where category = '$category'";
	$result = mysqli_query($conn,$query);
	$category = mysqli_fetch_array($result);
	$category_id = $category['id'];

	$query = "select * from subcategories where category_id = '$category_id' ";
	$result = mysqli_query($conn, $query);
	//$rowcount = mysqli_num_rows($result);
	if(!mysqli_num_rows($result)==0)
	{
		echo "<div class='form-group'>";
		echo "<label for='subcategory'>Subcategory:</label>";
		echo "<select class='custom-select custom-select-md' name='subcategory'>";
		if(isset($subcategory_name))
			echo '<option selected>'.$subcategory_name.'</option>';
		$subcategories = mysqli_fetch_all($result, MYSQLI_ASSOC);
		foreach ($subcategories as $subcategory) {
			echo '<option>'.$subcategory['subcategory'].'</option>';
		}
		echo "</select>";	
		echo "</div>";
	}

	$query = "select * from attributes where category_id = '$category_id' ";
	$result = mysqli_query($conn, $query);
	$attributes = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$i = 0;
	foreach ($attributes as $attribute) {
		$i++;
		echo "<div class='form-group'>";
		echo "<label for='".$attribute['attribute']."'>".$attribute['attribute'].":</label>";
		echo "<input type='text' class='form-control' name='attributes_values[]'  autocomplete='off'>";
		echo "</div>";
	}
	mysqli_free_result($result);
}

if(isset($_POST['id']))
{
	$product_id = $_POST["id"];
	$product = mysqli_fetch_array(mysqli_query($conn,"select * from products where id = '$product_id'"));

	$category = mysqli_fetch_array(mysqli_query($conn, "select * from categories where id = ".$product["category_id"].""), MYSQLI_ASSOC);
	$category_id = $category["id"];

	$subcategory = mysqli_fetch_array(mysqli_query($conn, "select * from subcategories where id = ".$product["subcategory_id"].""), MYSQLI_ASSOC);
	$subcategory_name = $subcategory["subcategory"];

	$query = "select * from subcategories where category_id = '$category_id' ";
	$result = mysqli_query($conn, $query);
	//$rowcount = mysqli_num_rows($result);
	if(!mysqli_num_rows($result)==0)
	{
		echo "<div class='form-group'>";
		echo "<label for='subcategory'>Subcategory:</label>";
		echo "<select class='custom-select custom-select-md' name='subcategory'>";
		if(isset($subcategory_name))
			echo '<option selected style="color:red">'.$subcategory_name.'</option>';
		$subcategories = mysqli_fetch_all($result, MYSQLI_ASSOC);
		foreach ($subcategories as $subcategory) {
			echo '<option>'.$subcategory['subcategory'].'</option>';
		}
		echo "</select>";	
		echo "</div>";
	}

	$query = "select * from attributes where category_id = '$category_id' ";
	$result = mysqli_query($conn, $query);
	$attributes = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$i = 0;
	foreach ($attributes as $attribute) {
		$attribute_id = $attribute["id"];
		$product_attribute = mysqli_fetch_array(mysqli_query($conn, "select * from product_attributes where attribute_id = ".$attribute_id." && product_id = ".$product_id.""), MYSQLI_ASSOC);
		$attribute_value = $product_attribute["attribute_value"];
		echo "<div class='form-group'>";
		echo "<label for='".$attribute['attribute']."'>".$attribute['attribute'].":</label>";
		echo "<input type='text' class='form-control' name='attributes_values[]' value ='".htmlspecialchars($attribute_value)."'  autocomplete='off'>";

		echo "</div>";
	}
	mysqli_free_result($result);
}

?>

