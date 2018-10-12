<?php 

	require_once('config/const.php');
	require_once('config/db.php');
	require_once('template/header.php');
 	require_once('template/nav.php');
 	require_once('config/function.php');
?>
<h3 class="container" style="margin-top: 30px; margin-bottom: 30px;">Search results </h3>
<?php 
	if (isset($_GET['submit-search'])) {
		$search = mysqli_real_escape_string($conn,$_GET['search']);
		$query = "SELECT * FROM products WHERE name LIKE '%$search%'";
		$result = mysqli_query($conn,$query);
		$queryResult = mysqli_num_rows($result);
	}

	echo "<p class='container'>There are $queryResult results</p>";
	echo "<div ><div class='container' id='product'><div class='row' id='row'>";
	if ($queryResult) {
		while ($row = mysqli_fetch_assoc($result)) {
			$product_id = $row["id"];	
			$files = glob("image/$product_id/*.*");
			if(!count($files))
				$files[0] = 'template/noimage.jpg';
			showProduct($product_id);
		}
	} else {
		echo "<p class='container'>There are no results matching your search</p>";
	}
	echo "</div></div>";
?>
<?php
	require_once('template/footer.php');
?>
