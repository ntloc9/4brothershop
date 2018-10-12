<?php 
require('config/db.php');
require('config/const.php');
include('template/header.php');
require('config/function.php'); 
include('template/nav.php');

if (isset($_SESSION['user_logged'])) {

	$user_id = mysqli_real_escape_string($conn,$_SESSION['user_logged']);
	$query = "SELECT * FROM users WHERE id = ".$user_id;
	$result = mysqli_query($conn,$query);
	//if (mysqli_num_rows($result)>0) {

	
	$user = mysqli_fetch_array($result);
}
?>
<form method="get" action="export-excel.php">
	<div id="border" style="margin-top: 20px;background-color: white">
		<div class="container" style="margin-bottom: 50px;">
			<h2 style="text-align: center; margin-top: 30px;"><b>PROFILE</b></h2>
			<table style="width: 100%; font-size: 20px; margin-top: 18px;">
				<tr>
					<th style="padding: 5px;">Name: </th>
					<td style="text-align: right; padding: 5px;"><?php echo $user['name']?></td>
				</tr>
				<tr>
					<th style="padding: 5px;">Day of birth: </th>
					<td style="text-align: right;padding: 5px;"><?php echo $user['birthday']?></td>
				</tr>
				<tr>
					<th style="padding: 5px;">Email: </th>
					<td style="text-align: right;padding: 5px;"><?php echo $user['email']?></td>
				</tr>
				<tr>
					<th style="padding: 5px;">Address: </th>
					<td style="text-align: right;padding: 5px;"><?php echo $user['address']?></td>
				</tr>
				<tr>
					<th style="padding: 5px;">Phone number: </th>
					<td style="text-align: right;padding: 5px;"><?php echo $user['phone']?></td>
				</tr>
				<tr>
					<th><a class="btn btn-success" href="transaction.php">Transaction History</a></th>
					<td align="right"><a href="change_password.php" class="btn btn-warning" >Change Password</a></td>
				</tr>
			</table>

			
		</div>
	</div>
</form>
<?php
include('template/footer.php');
?>

