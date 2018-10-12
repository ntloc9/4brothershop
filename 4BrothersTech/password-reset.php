
<?php 
include "/src/PHPMailer.php";
include "/src/Exception.php";
include "/src/OAuth.php";
include "/src/POP3.php";
include "/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('config/db.php');
require_once('config/const.php');
require_once('template/header.php');
require_once('config/function.php');

$email = NULL;
$emailErr = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST['email'];
	$query = "SELECT * FROM users where email = '$email'";
	$result = mysqli_query($conn,$query);
	if (mysqli_num_rows($result)) {
		$user = mysqli_fetch_array($result);
		$user_password = $user["password"];
		$user_email = $user["email"];
		
		$mail = new PHPMailer();
	    $title = 'Reset password';
	    $content = "<b>Dear ".$user["name"].",</b><br><br>
	    		We're regret that you have forgotten you password. Please click this <a href='http://localhost/4brotherstech/change_password.php?id=$user_email&key=$user_password'><b>link</b></a> to reset it
	    		<br><br>
	    		<b>Best regards,<br>
	    		Admin Team</b>";
	    $nTo = $user["name"];
	    $mTo = $user['email'];
	    sendMail($title, $content, $nTo, $mTo,$diachicc='');
	    echo "<script>
					alert('We have sent you email. Please check you mail box!');				
				</script>";		
	}else{
		$accErr = "Email not found!";
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
<title>Reset password</title>
</head>
<body>
	<div class="container">
		<div class="card card-container">
			<!-- <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" /> -->
			<h4>Enter your email</h4>
			<p id="profile-name" class="profile-name-card"></p>
			<form class="form-signin" method="POST" action="password-reset.php">
				<span id="reauth-email" class="reauth-email"></span>
				<input type="email" name="email" class="form-control" placeholder="Email address" required autofocus value="<?php echo $email; ?>" >
				<span id="accErr"><?php echo $accErr; ?></span><br>
				<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Reset Password</button>
			</form><!-- /form -->
		</div><!-- /card-container -->
	</div><!-- /container -->
	<?php require_once('template/footer.php'); ?>
</body>
</html>

