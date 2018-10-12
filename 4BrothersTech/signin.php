
<?php 
require_once('config/db.php');
require_once('config/const.php');
require_once('template/header.php');
require_once('config/function.php');

$email = $password = NULL;
$emailErr = $passwordErr = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	if(isset($_POST["remember"])){
		$_SESSION["password"] = $_POST["password"];
	}
	$query = "SELECT * FROM users where email = '$email' && password = '$password'";
	$result = mysqli_query($conn,$query);
	if (mysqli_num_rows($result)) {
		$user = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$_SESSION['user_logged'] = $user['id'];
		$_SESSION['user_type'] = $user['type'];
		$_SESSION['user_name'] = $user['name'];
		if ($user["type"] == "admin") {
			redirect('admincp/index.php');
		}
		else{
			redirect('index.php');
		}
	}else{
		$accErr = "Incorrect email or password!";
	}
}
require_once("template/nav.php")			
?>
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

<title>Login</title>
</head>
<body>
	<div class="container">
		<div class="card card-container">
			<!-- <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" /> -->
			<h4 align="center">Log in</h4>
			<p id="profile-name" class="profile-name-card"></p>
			<form class="form-signin" method="POST" action="signin.php">
				<span id="reauth-email" class="reauth-email"></span>
				<input type="email" name="email" class="form-control" placeholder="Email address" required autofocus value="<?php echo $email; ?>">
				<input type="password" name="password" class="form-control" placeholder="Password" required value="<?php echo $_SESSION['password']; ?>">
				</input><br>
				<!-- <div id="remember" class="checkbox" name="remember">
					<label>
						<input type="checkbox" value="remember-me"> Remember me
					</label>
				</div> -->
				<span id="accErr"><?php echo $accErr; ?></span>
				<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
			</form><!-- /form -->
			<a href="password-reset.php" class="forgot-password">
				Forgot the password?
			</a>
		</div><!-- /card-container -->
	</div><!-- /container -->
	<?php require_once('template/footer.php'); ?>
</body>
</html>

