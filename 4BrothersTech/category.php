<?php 
require_once('config/const.php');
require_once('config/function.php');
require_once('config/db.php');
require_once('template/header.php');
require_once('template/nav.php');
if(isset($_GET[cate_id]))
{
	$category_id = mysqli_real_escape_string($conn, $_GET["cate_id"]);
	$category_names =  mysqli_fetch_array(mysqli_query($conn,"select * from categories where id = $category_id limit 1"),MYSQLI_ASSOC);
	$category_name = $category_names["category"];
} elseif(isset($_GET[branch_id]))
{
	$branch_id = mysqli_real_escape_string($conn, $_GET["branch_id"]);
	$branch_names =  mysqli_fetch_array(mysqli_query($conn,"select * from product_branch where id = $branch_id limit 1"),MYSQLI_ASSOC);
	$branch_name = $branch_names["branch"];
}
?>
<h3 class="container">
	<?php if(isset($_GET[cate_id]))
	{
		echo $category_name;
	} elseif(isset($_GET[branch_id]))
	{
		echo $branch_name;;
	} ?>

</h3>
<?php  
if(isset($_GET[cate_id]))
{
	showProductbyCategory($category_id);
} elseif(isset($_GET[branch_id]))
{
	showProductbyBranch($branch_id);
}

require_once('template/footer.php');
?>