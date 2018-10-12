
<!DOCTYPE html>
<html>
<head>
	<style>
	.card-container.card {
		max-width: 350px;
		padding: 40px 40px;
		align-self: center;
	}
	.card {
		background-color: #F7F7F7;
		/* just in case there no content*/
		padding: 20px 25px 30px;
		margin: 0 auto 25px;
		margin-top: 50px;
		/* shadows and rounded borders */
		-moz-border-radius: 2px;
		-webkit-border-radius: 2px;
		border-radius: 2px;
		-moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		-webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	}
	#accErr {
		color: red;
		font-weight: bold;	
	}
</style>

<title>Change Password</title>
</head>
<body>
<?php 
	require_once('config/db.php');
	require_once('config/const.php');
	require_once('config/function.php');
	require_once('template/header.php');
	require_once("template/nav.php");
	//get user id and password from reset link
	if (isset($_GET["id"])) {
		$email = $_GET['id'];
		$password = $_GET['key'];
		$query = "SELECT * FROM users where email = '$email' && password = '$password'";
		$result = mysqli_query($conn,$query);
		if (mysqli_num_rows($result)) {
			$user = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$_SESSION['user_logged'] = $user['id'];
			$_SESSION['user_type'] = $user['type'];
			$_SESSION['user_name'] = $user['name'];
			redirect("change_password.php");
		}else{
			redirect("index.php");
		}
	}

	if(!isset($_SESSION['user_logged']))
		redirect("index.php");

	$re_passwordErr = $passwordErr = "";
	function checkChange(){
		$rs = true;
		global $newpw ,	$renewpw, $re_passwordErr, $passwordErr;
		if (empty($newpw)){
			$passwordErr =  "Password is required!<br/>";
			$rs = false;
		}
		if (empty($renewpw)) {
			$re_passwordErr = "Password confirmation is required!<br>";
			$rs = false;
		} elseif ($renewpw != $newpw) {
			$re_passwordErr = "Passwords not match!";
			$rs = false;
		}
		return $rs;
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$newpw = $_POST['newpw'];
		$renewpw = $_POST['renewpw'];
		if(checkChange()){
			$newpw = md5($newpw);
			$query = "UPDATE users SET password = '$newpw' where id = ".$_SESSION['user_logged']."";
			confirm(mysqli_query($conn,$query));
			echo "<script>
					alert('Change password successfully!');
				</script>";

		} 
	}
 ?>	
	<div class="container">
    <form class="form-horizontal" role="form" method="POST" action="">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-6">
                <h2>Enter new password</h2>
                <hr>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-2"></div>
            <div class="col-md-2 field-label-responsive">
                <label for="password">Password</label>
            </div>
            <div class="col-md-5">
                <div class="form-group has-danger">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                        <input type="password" name="newpw" class="form-control" id="newpw"
                        placeholder="password" required>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                         <?php echo "<i class=\"error\">".$passwordErr."</i>"; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-2"></div>
            <div class="col-md-2 field-label-responsive">
                <label for="password">Confirm Password</label>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-repeat"></i> </div>
                        <input type="password" name="renewpw" class="form-control"
                        id="re_password" placeholder="confirm password" required>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                         <?php echo "<i class=\"error\">".$re_passwordErr."</i>"; ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6" align="center">
                <button type="submit" class="btn btn-success"><i class="fa fa-key"></i> Change</button>
            </div>
        </div>
    </form>
</div>
	<?php require_once('template/footer.php'); ?>
</body>
</html>

