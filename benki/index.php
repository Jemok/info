<?php
session_start();
include_once 'includes/dbconnect.php';

if(isset($_SESSION['admin_user']))
{
	Header("Location: http://localhost/benki/admin/home.php");	
}
if(isset($_SESSION['user']))
{
	Header("Location: http://localhost/benki/home.php");
}

if(isset($_POST['btn-login']))
{
	$email = mysql_real_escape_string($_POST['email']);
	$upass = mysql_real_escape_string($_POST['pass']);
	$res=mysql_query("SELECT * FROM tbl_users WHERE email='$email'");
	$row=mysql_fetch_array($res);
	
	if($row['password']==md5($upass))
	{
		$_SESSION['user'] = $row['user_id'];
		header("Location: home.php");
	}
	else
	{
		?>
        <script>alert('wrong details');</script>
        <?php
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Benki | Login</title>
<link rel="stylesheet" href="css/style-rl.css" type="text/css" />
</head>
<body style="background: #fff url(images/Apple.jpg) no-repeat center fixed" >
<center>
<div id="login-form">
<form method="post">
<table align="center" width="30%" border="0" style="background: rgba(255,255,255,0.3)" >
<tr>
<td><input type="text" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-login">Sign In</button></td>
</tr>
<tr>
<td><a href="register.php">Sign Up Here</a></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>