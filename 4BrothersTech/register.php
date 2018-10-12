<!DOCTYPE html>
<html>
<head>
    <title>
        Registration a new customer
    </title>
</head>
<body>
    <?php 

    include "/src/PHPMailer.php";
    include "/src/Exception.php";
    include "/src/OAuth.php";
    include "/src/POP3.php";
    include "/src/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require_once('config/const.php');
    require_once('config/db.php');
    require_once('template/header.php');
    require_once('template/nav.php') ;
    require_once('config/function.php') ;

    if(isset($_SESSION['user_logged']))
        redirect("index.php");

    $date =  date('Y-m-d H:i:s');
    $created_date = date('Y-m-d H:i:s', strtotime($date));  

    $email = $password = $re_password = $address = $birthday = $name = $phone  = NULL;
    $emailErr = $passwordErr =  $re_passwordErr = $addressErr = $birthdayErr = $nameErr = $phoneErr =   NULL;
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST["password"];   
        $re_password = $_POST['re_password'];
        $address = $_POST["address"];
        $birthday = $_POST["birthday"];
        $name = $_POST["name"]; 
        $phone = $_POST["phone"];
        
        if (validation_new()){
            $password = md5($_POST['password']);
            $query = "INSERT INTO users (email, password, address,birthday,name,phone,type,created_day) 
            VALUES ('$email','$password','$address','$birthday','$name','$phone','customer','$created_date' )";
            confirm(mysqli_query($conn,$query));
            $user_id = mysqli_insert_id($conn);
            //send welcome email
            $mail = new PHPMailer();
            $title = 'Welcome to 4BrothersTech!';
            $content = "<b>Dear ". $name.",</b><br><br>
                        Thanks for registering. Enjoy buying comfortably and affordrably at out website. <br>
                        For any concern, dont hesitate to get in touch with us via phone or feedback.<br>
                        <small text-align='right'>This is automated email. Please do not reply it.</small>
                        <br><br>
                        <b>Best regards,<br>
                        Admin Team</b>";
            $nTo = $name;
            $mTo = $email;
            sendMail($title, $content, $nTo, $mTo,$diachicc='');
            //set session
            $_SESSION['user_logged'] = $user_id;
            $_SESSION['user_type'] = "customer";
            $_SESSION['user_name'] = $name;
            redirect('index.php');
        }
    }

    function validation_new() {
        global $conn;
        global $email,$password,$re_password,$address,$birthday,$name,$phone;
        global $emailErr,$passwordErr,$re_passwordErr,$addressErr,$birthdayErr,$nameErr,$phoneErr;
        $rs = true;
        if (empty($email)) {
            $emailErr =  "Email is required!<br/>";
            $rs = false;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Email is not valid";
            $rs = false;
        } elseif (mysqli_fetch_array(mysqli_query($conn,"select * from users where email = '$email'"),MYSQLI_ASSOC)){
            $emailErr = "This email is used";
             $rs = false;
        }
        if (empty($password)){
            $passwordErr =  "Password is required!<br/>";
            $rs = false;
        }
        if (empty($re_password)) {
            $re_passwordErr = "Password confirmation is required!<br>";
            $rs = false;
        } elseif ($re_password != $password) {
            $re_passwordErr = "Passwords not match!";
            $rs = false;
        }
        if (empty($address)) {
            $addressErr = "Address is required!<br/>";
            $rs = false;
        }
        if (empty($birthday)) {
            $birthdayErr = "Birthday is required!<br>";
            $rs = false;
        } 
        if (empty($name)) {
            $nameErr = "No empty name!<br>";
            $rs = false;
        }
        if (empty($phone)) {
            $phoneErr = "Phone is required!<br>";
            $rs = false;
        }

        return $rs;
    }
?>

<div class="container" style="background-color: white">
    <form class="form-horizontal" role="form" method="POST" action="">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-6">
                <h2>Register New User</h2>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-2 field-label-responsive">
                <label for="name">Name</label>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
                        <input type="text" name="name" class="form-control" id="name"
                        placeholder="enter your name here" required autofocus value>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <?php echo "<i class=\"error\">".$nameErr."</i>"; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-2 field-label-responsive">
                <label for="phone">Phone number</label>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-mobile"></i></div>
                        <input type="text" name="phone" class="form-control" id="phone"
                        placeholder="enter your phone number here" required >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <?php echo "<i class=\"error\">".$phoneErr."</i>"; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-2 field-label-responsive">
                <label for="birth">Birthday</label>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-birthday-cake"></i></div>
                        <input type="date" name="birthday" class="form-control" id="birth" required >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <?php echo "<i class=\"error\">".$birthdayErr."</i>"; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-2 field-label-responsive">
                <label for="adress">Address</label>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-map-o"></i></div>
                        <input type="text" name="address" class="form-control" id="address"
                        placeholder="enter your address here" required >
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <?php echo "<i class=\"error\">".$addressErr."</i>"; ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-2 field-label-responsive">
                <label for="email">E-Mail Address</label>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                        <input type="text" name="email" class="form-control" id="email"
                        placeholder="enter your email here" required autofocus>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <?php echo "<i class=\"error\">".$emailErr."</i>"; ?>
                    </span>
                </div>
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
                        <input type="password" name="password" class="form-control" id="password"
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
                        <input type="password" name="re_password" class="form-control"
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
            <div class="col-md-4"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i> Register</button>
                <button type="button" class="btn btn-success" onclick="location.href='signin.php'"><i class="fa fa-user"></i> Log In</button>
            </div>

        </div>
    </div>

    </form>
</div>

</div>

<?php require_once('template/footer.php'); ?>
</body>
</html>