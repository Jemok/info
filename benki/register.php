<?php
session_start();
include_once 'includes/dbconnect.php';

if(isset($_SESSION['user']))
{
	Header("Location: http://localhost/benki/home.php");
}

if(isset($_POST['btn-signup']))
{
	$digits = 5;
	$user_id= rand(pow(10, $digits-1), pow(10, $digits)-1);
	$full_names = mysql_real_escape_string($_POST['full_names']);
	if(ctype_digit($_POST['phone_no']))
	{
		$phone_no = mysql_real_escape_string($_POST['phone_no']);
	}
	else
	{
		?>
        <script>alert('Phone number must be a Digit ');</script>
        <?php
	}
	$email = mysql_real_escape_string($_POST['email']);
	if($_POST['pass'] != $_POST['cpass'] )
	{
		?>
        <script>alert('Passwords do not match ');</script>
        <?php
	}
	else
	{
		$pass = md5(mysql_real_escape_string($_POST['pass']));
	}
	$res= mysql_query("INSERT INTO tbl_users(user_id,full_names,phone_no,role,email,password) VALUES('$user_id','$full_names','$phone_no','3','$email','$pass')") or die(mysql_error());
	$res1= mysql_query("INSERT INTO tbl_current_account(ref_user) VALUES('$user_id')") or die(mysql_error());
	if(	$res && $res1 )
	{
		?>
        <script>alert('successfully registered ');</script>
        <?php
	}
	else
	{
		?>
        <script>alert('error while registering you...');</script>
        <?php
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Benki | Register</title>
<link rel="stylesheet" href="css/style-rl.css" type="text/css" />

</head>
<body style="background: #fff url(images/Apple.jpg) no-repeat center fixed">
<center>
<div id="login-form">
<form method="post" >
<table align="center" width="30%" border="0" style="background: rgba(255,255,255,0.3)">
<tr>
<td><input type="text" name="full_names" placeholder="Your Full Names" required /></td>
</tr>
<tr>
<td><input type="text" name="phone_no" placeholder="Your Phone Number" required /></td>
</tr>
<tr>
<td><input type="email" name="email" placeholder="Your Email" required /></td>
</tr>
<tr>
<td><input type="password" name="pass" placeholder="Your Password" required /></td>
</tr>
<tr>
<td><input type="password" name="cpass" placeholder="Confirm Password" required /></td>
</tr>
<tr>
<td><button type="submit" name="btn-signup">Sign Me Up</button></td>
</tr>
<tr>
<td><a href="index.php">Sign In Here</a></td>
</tr>
</table>
</form>
</div>
</center>
</body>
</html>