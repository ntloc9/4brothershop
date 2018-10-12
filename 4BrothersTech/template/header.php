<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=0.8">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>4Brothers Tech Store</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
  <link href="css/product_detail.css" rel="stylesheet">
<style type="text/css" >
  <style type="text/css" >
  <?php include('template/style.css'); ?>   
  @media screen and (max-width: 767px){nav {background: #bd4444;width: auto;}.dropdown-menu li {background-color: #E1E1E1;}

</style>
</head>
<body style="background-color:rgba(181, 181, 181, 1)">
   <div>
    <a href=""><img class="left_banner" src="template/left-banner.png" width="12%"></a>
   </div>
  <div class="container">
  <div id="topheader">
    <div class="container">
      <div id="hotline">
        Hotline : (+84) 933 9898 81
      </div>
      <div id="topmenu">
        <ul>
          <?php
          if(isset($_SESSION["user_logged"]))
          {
            if($_SESSION["user_type"] == 'admin') {
               echo  "<li><a href='admincp/index.php' class='no-underline'><i class='fa fa-sign-in'></i>Admin Dashboard</a></li>";
            } else {
              echo  "<li><a href='user.php' class='no-underline'><i class='fa fa-sign-in'></i>Welcome ".$_SESSION['user_name']."</a></li>";
            }
            echo  "<li><a href='logout.php' class='no-underline'><i class='fa fa-sign-in'></i>Log Out</a></li>";
          } else {
            echo '<li><a href="signin.php" class="no-underline"><i class="fa fa-sign-in"></i>Log in</a></li>';
            echo '<li><a href="register.php" class="no-underline"><i class="fa fa-user"></i>Register</a></li>';
          }
          ?>
          
        </ul>
      </div>
    </div>
  </div>
  <form action="search.php" method="GET">
  <header id="header" style="padding:7px">
    <div class="container">
      <div class="row" >
        <div class="col-md-4">
          <a class="no-underline" href="<?php echo 'index.php' ?>" class="logo"><img src="template/logo.png" width="270px" /></a>
        </div>
        <div class="col-md-6 input-group" >
          <input class="form-control py-2 border-right-0 border" type="search" value="" placeholder="Search" id="example-search-input" name="search"  style="height:100%">
          <span class="input-group-append">
            <button class="btn btn-outline-secondary border-left-0 border" type="submit" name="submit-search" id="btn-search" oncl>
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div>
        <div class="col-md-1">
          <div id="ex4">
            <span class="p1 fa-stack fa-2x has-badge" data-count="<?php echo isset($_SESSION['item_quantity']) ? $_SESSION['item_quantity'] : $_SESSION['item_quantity'] =0; ?>">
              <a  href="<?php echo ROOT_URL . "cart-show.php" ?>"><i class="p3 fa fa-shopping-cart fa-stack-2x xfa-inverse icon-black" data-count="<?php echo isset($_SESSION['item_quantity']) ? $_SESSION['item_quantity'] : $_SESSION['item_quantity'] =0; ?>"></i>
               </a>
            </span>
          </div>
        </div>
        <div class="col-md-1">
          <div id="ex4">
            <span class="p1 fa-heart fa-2x ">
              <a  href="<?php echo ROOT_URL . "wishlist-show.php" ?>"><i class="p3 fa fa-heart fa-stack-2x xfa-inverse icon-black"></i></a>
            </span>
          </div>
        </div>
      </div>
    </div>
  </header>
</form>