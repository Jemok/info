<?php
session_start();
include_once 'includes/dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: http://localhost/benki/index.php");
}
$res=mysql_query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

if(isset($_POST['savings_account_submit']))
{
	date_default_timezone_set('Africa/Nairobi');
	
	$date= date("d/m/Y");
	$time= date("h:i a");
	$var=$_SESSION['user'];
	$savings_account_percentage=filter_input(INPUT_POST, 'savings_account_percentage', FILTER_SANITIZE_STRING);
	$savings_account_duration=filter_input(INPUT_POST, 'savings_account_duration', FILTER_SANITIZE_STRING);
	$savings_account_withdraw_date=filter_input(INPUT_POST, 'savings_account_withdraw_date', FILTER_SANITIZE_STRING);
	$savings_account_password=filter_input(INPUT_POST, 'savings_account_password', FILTER_SANITIZE_STRING);
	$password=md5($savings_account_password);
	
	//Check if the amount is more than the amount in the current account
	$ress=mysql_query("SELECT current_account FROM tbl_current_account WHERE ref_user= '$var' ")or die(mysql_error());
	if(mysql_num_rows($ress)==1)
	{
		$row=mysql_fetch_array($ress);
		$current_account=$row['current_account'];
	
		//Check if such a user exists
		$resa=mysql_query("SELECT password FROM tbl_users WHERE user_id='$var' AND password = '$password' ")or die(mysql_error());
		if(mysql_num_rows($resa)==1)
		{
			$resz=mysql_query(" SELECT savings_account FROM tbl_savings_account WHERE ref_user='$var' ")or die(mysql_error());
			$rowz=mysql_fetch_array($resz);
			$current_savings_account=$rowz['savings_account'];
			
			$balance= $current_account - ($savings_account_percentage/100 * $current_account);
			$total_savings_account=($savings_account_percentage/100 * $current_account)+$current_savings_account;
			//Check duration type
			if($savings_account_duration == 1)
			{
				$ress=mysql_query("DROP EVENT IF EXISTS auto_update_$var")or die(mysql_error());
				$res=mysql_query("	CREATE EVENT auto_update_$var
									ON SCHEDULE EVERY 1 DAY 
									STARTS CURRENT_TIMESTAMP
									ON COMPLETION PRESERVE ENABLE 
									DO
										BEGIN
										INSERT INTO tbl_savings_account (ref_user,percentage,duration,withdraw_date,savings_account,date,time) VALUES('$var','$savings_account_percentage','$savings_account_duration','$savings_account_withdraw_date','$total_savings_account','$date','$time')
										ON DUPLICATE KEY UPDATE percentage='$savings_account_percentage',
																duration='$savings_account_duration',
																savings_account='$total_savings_account',
																withdraw_date='$savings_account_withdraw_date',
																date='$date',
																time='$time';
									END;")or die(mysql_error());
			}
			else if($savings_account_duration == 2)
			{
				$ress=mysql_query("DROP EVENT IF EXISTS auto_update_$var")or die(mysql_error());
				$res=mysql_query("	CREATE EVENT auto_update_$var
									ON SCHEDULE EVERY 1 WEEK 
									STARTS CURRENT_TIMESTAMP
									ON COMPLETION PRESERVE ENABLE 
									DO
										BEGIN
										INSERT INTO tbl_savings_account (ref_user,percentage,duration,withdraw_date,savings_account,date,time) VALUES('$var','$savings_account_percentage','$savings_account_duration','$savings_account_withdraw_date','$total_savings_account','$date','$time')
										ON DUPLICATE KEY UPDATE percentage='$savings_account_percentage',
																duration='$savings_account_duration',
																savings_account='$total_savings_account',
																withdraw_date='$savings_account_withdraw_date',
																date='$date',
																time='$time';
									END;")or die(mysql_error());
			}
			else
			{
				$ress=mysql_query("DROP EVENT IF EXISTS auto_update_$var")or die(mysql_error());
				$res=mysql_query("	CREATE EVENT auto_update_$var
									ON SCHEDULE EVERY 1 MONTH 
									STARTS CURRENT_TIMESTAMP
									ON COMPLETION PRESERVE ENABLE 
									DO
										BEGIN
										INSERT INTO tbl_savings_account (ref_user,percentage,duration,withdraw_date,savings_account,date,time) VALUES('$var','$savings_account_percentage','$savings_account_duration','$savings_account_withdraw_date','$total_savings_account','$date','$time')
										ON DUPLICATE KEY UPDATE percentage='$savings_account_percentage',
																duration='$savings_account_duration',
																savings_account='$total_savings_account',
																withdraw_date='$savings_account_withdraw_date',
																date='$date',
																time='$time';
									END;")or die(mysql_error());
			}
			$resc=mysql_query(" UPDATE tbl_current_account SET current_account='$balance' WHERE ref_user='$var' ")or die(mysql_error());
		}
		else
		{
			?>
				<script>
					alert("Error: Wrong Password");
					window.location.replace("http://localhost/benki/savings.php");
				</script>
			<?php
		}
	}
	else
	{
	
	}
	
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Savings Account | <?php echo $userRow['full_names'];?></title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!--jQuery(necessary for Bootstrap's JavaScript plugins)-->
<script src="js/jquery-1.11.0.min.js"></script>
<!--Custom-Theme-files-->
<!--theme-style-->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->

<link rel="stylesheet" href="css/date_picker/jquery-ui-1.10.4.css" >
<link rel="stylesheet" href="css/date_picker/css/jquery-ui-1.10.4.min.css" >

<script type="text/javascript" src="css/date_picker/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="css/date_picker/js/jquery-ui-1.10.4.js"></script>
<script type="text/javascript"  src="css/date_picker/js/jquery-ui-1.10.4.min.js"></script>

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Luxury Watches Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--start-menu-->
<script src="js/simpleCart.min.js"> </script>
 <link href="css/normalize.css" rel="stylesheet">
<link href="css/memenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/memenu.js"></script>
<script>$(document).ready(function(){$(".memenu").memenu();});</script>	
<!--dropdown-->
<script src="js/jquery.easydropdown.js"></script>

<script>
		$(function()
		{
			$("#withdraw_date").datepicker();
		});
</script>			
</head>
<body> 
	<!--top-header-->
	<div class="top-header">
		<div class="container">
			<div class="top-header-main">
				<div class="col-md-6 top-header-left">
					<div class="drop">
						
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="col-md-6 top-header-left">
					<div class="cart box_1">
						<a href="checkout.php">
							 <div class="total">
								<?php
									$res=mysql_query("SELECT current_account FROM tbl_current_account WHERE ref_user=".$_SESSION['user']);
									$userRow=mysql_fetch_array($res);
									echo 'Ksh '.$userRow['current_account'].'.00';
								?>
								
							 </div>
								<img src="images/cart-1.png" alt="" />
						</a>
						<p style="display:inline;" ><a href="javascript:;" class="simpleCart_empty">Current Account &nbsp;|</a></p>
						<p style="display:inline;" ><a href="includes/logout.php?logout" class="simpleCart_empty">Logout</a></p>
						<div class="clearfix"> </div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--bottom-header-->
	<!--start-breadcrumbs-->
	<div class="logo">
		<a href="index.php"><h1>benki</h1></a>
	</div>
	<!--end-breadcrumbs-->
<div class="breadcrumbs">
		<div class="container">
			<div class="breadcrumbs-main">
				<ol class="breadcrumb">
                                        <li><a href="index.php">Home</a></li>
					<li><a href="#">Deposit</a></li>
                                        <li><a href="#">Withdraw</a></li>
                                        <li><a href="#">Transfer</a></li>
					
					
				</ol>
			</div>
		</div>
	</div>
	<!--register-starts-->
	<div class="register">
		<div class="container">
			<div class="register-top heading">
				<h2>Savings Account</h2>
			</div>
			<div class="register-main">
				<form class="col-md-6 account-left" method="post" >
					<input placeholder="Enter percentage (%) to deduct" name="savings_account_percentage" type="text" tabindex="1" required />
                    <ul>
						<li><label class="radio"><input type="radio" name="savings_account_duration" value="1" checked=""><i></i>Daily</label></li><br>
						<li><label class="radio"><input type="radio" name="savings_account_duration" value="2"><i></i>Weekly</label></li><br>
						<li><label class="radio"><input type="radio" name="savings_account_duration" value="3"><i></i>Monthly</label></li>
						<div class="clearfix"></div>
					</ul>
					<input placeholder="Withdrawal date" name="savings_account_withdraw_date" id="withdraw_date" type="text" tabindex="2" required>
                    <input placeholder="Enter Password" type="password" name="savings_account_password" tabindex="4" required />
					<div class="clearfix"></div>
					<div class="address submit">
						<input type="submit" value="Save" name="savings_account_submit" > 
					</div>
				</form>
			</div>
			
		</div>
	</div>
	<!--register-end-->
	<!--information-starts-->
	<div class="information">
		<div class="container">
			<div class="infor-top">
				<div class="col-md-3 infor-left">
				<!--	<h3>Follow Us</h3>
					<ul>
						<li><a href="#"><span class="fb"></span><h6>Facebook</h6></a></li>
						<li><a href="#"><span class="twit"></span><h6>Twitter</h6></a></li>
						<li><a href="#"><span class="google"></span><h6>Google+</h6></a></li>
					</ul>
				</div>
				<div class="col-md-3 infor-left">
					<h3>Information</h3>
					<ul>
						<li><a href="#"><p>Specials</p></a></li>
						<li><a href="#"><p>New Products</p></a></li>
						<li><a href="#"><p>Our Stores</p></a></li>
						<li><a href="contact.php"><p>Contact Us</p></a></li>
						<li><a href="#"><p>Top Sellers</p></a></li>
					</ul>
				</div>
				<div class="col-md-3 infor-left">
					<h3>My Account</h3>
					<ul>
						<li><a href="account.php"><p>My Account</p></a></li>
						<li><a href="#"><p>My Credit slips</p></a></li>
						<li><a href="#"><p>My Merchandise returns</p></a></li>
						<li><a href="#"><p>My Personal info</p></a></li>
						<li><a href="#"><p>My Addresses</p></a></li>
					</ul>
				</div>
				<div class="col-md-3 infor-left">
					<h3>Store Information</h3>
					<h4>The company name,
						<span>Lorem ipsum dolor,</span>
						Glasglow Dr 40 Fe 72.</h4>
					<h5>+955 123 4567</h5>	
					<p><a href="mailto:example@email.com">contact@example.com</a></p>
				</div>-->
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--information-end-->
	<!--footer-starts-->
	<div class="footer">
		<div class="container">
			<div class="footer-top">
				<div class="col-md-6 footer-left">
					
				</div>
				<div class="col-md-6 footer-right">					
					<p>© 2015 benki <a href="#" target="_blank"></a> </p>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--footer-end-->	
</body>
</html>
