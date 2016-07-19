<?php
	session_start();
	include_once '../includes/dbconnect.php';

	if(isset($_SESSION['admin_user']))
	{
		Header("Location: http://localhost/benki/admin/home.php");	
	}
	if(isset($_SESSION['user']))
	{
		Header("Location: http://localhost/benki/home.php");
	}
	
	if(isset($_POST['admin-login']))
	{
		$email = mysql_real_escape_string($_POST['admin_email']);
		$upass = mysql_real_escape_string($_POST['admin_password']);
		$res=mysql_query("SELECT * FROM tbl_users WHERE email='$email' AND role='1' ");
		$row=mysql_fetch_array($res);
		
		if($row['password']==md5($upass))
		{
			$_SESSION['admin_user'] = $row['user_id'];
			header("Location: http://localhost/benki/admin/home.php");
		}
		else
		{
			?>
			<script>alert('Wrong admin details');</script>
			<?php
		}
		
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Benki | Admin Login</title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-img3-body">

    <div class="container">

      <form class="login-form" method="post" action="">        
        <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt"></i></p>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              <input type="email" class="form-control"  name="admin_email" placeholder="Email" autofocus>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" class="form-control" name="admin_password" placeholder="Password">
            </div>
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right"> <a href="#"> Forgot Password?</a></span>
            </label>
            <button class="btn btn-primary btn-lg btn-block" name="admin-login" type="submit">Login</button>
            <a href="http://localhost/benki/register.php" class="btn btn-info btn-lg btn-block" style="text-decoration:none; font-color:white;" type="submit">Signup</a>
        </div>
      </form>

    </div>


  </body>
</html>
