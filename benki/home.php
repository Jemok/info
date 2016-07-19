<?php
session_start();
include_once 'includes/dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: http://localhost/benki/index.php");
}
$res=mysql_query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
?>

<!DOCTYPE html>
<html>
<head>
<title>Benki | <?php echo $userRow['full_names']; ?></title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!--jQuery(necessary for Bootstrap's JavaScript plugins)-->
<script src="js/jquery-1.11.0.min.js"></script>
<!--Custom-Theme-files-->
<!--theme-style-->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />	
<!--//theme-style-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Luxury Watches Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--start-menu-->
<script src="js/simpleCart.min.js"> </script>
<link href="css/memenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/memenu.js"></script>
<script>$(document).ready(function(){$(".memenu").memenu();});</script>	
<!--dropdown-->
<script src="js/jquery.easydropdown.js"></script>	
<script type="text/javascript">
	$(function() {
	
	    var menu_ul = $('.menu_drop > li > ul'),
	           menu_a  = $('.menu_drop > li > a');
	    
	    menu_ul.hide();
	
	    menu_a.click(function(e) {
	        e.preventDefault();
	        if(!$(this).hasClass('active')) {
	            menu_a.removeClass('active');
	            menu_ul.filter(':visible').slideUp('normal');
	            $(this).addClass('active').next().stop(true,true).slideDown('normal');
	        } else {
	            $(this).removeClass('active');
	            $(this).next().stop(true,true).slideUp('normal');
	        }
	    });
	
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
	<!--top-header-->
	<!--start-logo-->
	<div class="logo">
		<a href="index.php"><h1>Benki</h1></a>
	</div>
	<!--start-logo-->
	<!--bottom-header-->
	<div class="header-bottom">
		<div class="container">
			<div class="header">
				<div class="col-md-9 header-left">
				<div class="top-nav">
					
			</div>
			<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!--bottom-header-->
	<!--start-breadcrumbs-->
	<div class="breadcrumbs">
		<div class="container">
			<div class="breadcrumbs-main">
				<ol class="breadcrumb">
					<li><a href="#">Deposit</a></li>
                                        <li><a href="#">Withdraw</a></li>
                                        <li><a href="#">Transfer</a></li>
					
				</ol>
			</div>
		</div>
	</div>
	<!--end-breadcrumbs-->
<div class="register">
		<div class="container">
			<div class="register-top heading">
				<h2>Your Hand Bank</h2>
			</div>
	<!--start-single-->
	<!--<div class="single contact">
		
				</div>-->
				<div class="tabs">
					<ul class="menu_drop">
				<li class="item1"><a href="fixed.php"><img src="images/arrow.png" alt="">Fixed Account</a>
					<ul>
						<li class="subitem1"><a href="fixed.php"><h2 style="color:blue;text-decoration:none;">Access Fixed Account</h2></a></li>
						<li class="subitem2" style="height:120px; background:#fff;">
							<h2 style="color:blue;text-decoration:none;">Details</h2><br/>
							<?php
								$var=$_SESSION['user'];
								$res=mysql_query("SELECT * FROM tbl_fixed_account WHERE ref_user='$var'")or die(mysql_error());
								if($row=mysql_fetch_array($res))
								{
									echo'
										
										<h2 style="color:grey;display:inline;  text-decoration:none;font-size:12px;"></h2>CURRENT AMOUNT: <h2 style="color:blue;display:inline;  text-decoration:none;font-size:12px;">Ksh. '.$row['fixed_account'].'</h2><br/>
										<h2 style="color:grey;display:inline;  text-decoration:none;font-size:12px;"></h2>WITHDRAWAL DATE: <h2 style="color:blue;display:inline;  text-decoration:none;font-size:12px;">'.$row['withdraw_date'].'</h2><br/>
										<h2 style="color:grey;display:inline;  text-decoration:none;font-size:12px;"></h2>UPDATED ON: <h2 style="color:blue;display:inline;  text-decoration:none;font-size:12px;">'.$row['date'].' @ &nbsp; '.$row['time'].'</h2><br/>
									';
								}
							?> 
						</li>
					</ul>
				</li>
				<li class="item2"><a href="saving.php"><img src="images/arrow.png" alt="">Savings Account</a>
					<ul>
					    <li class="subitem2"><a href="saving.php"><h2 style="color:blue;text-decoration:none;">Access Savings Account</h2> </a></li>
						<li class="subitem2" style="height:120px; background:#fff;">
							<h2 style="color:blue;text-decoration:none;">Details</h2><br/>
							<?php
								$var=$_SESSION['user'];
								$res=mysql_query("SELECT * FROM tbl_savings_account WHERE ref_user='$var'")or die(mysql_error());
								if($row=mysql_fetch_array($res))
								{
									echo'
										
										<h2 style="color:grey;display:inline;  text-decoration:none;font-size:12px;"></h2>CURRENT AMOUNT: <h2 style="color:blue;display:inline;  text-decoration:none;font-size:12px;">Ksh. '.$row['savings_account'].'</h2><br/>
										<h2 style="color:grey;display:inline;  text-decoration:none;font-size:12px;"></h2>WITHDRAWAL DATE: <h2 style="color:blue;display:inline;  text-decoration:none;font-size:12px;">'.$row['withdraw_date'].'</h2><br/>
										<h2 style="color:grey;display:inline;  text-decoration:none;font-size:12px;"></h2>UPDATED ON: <h2 style="color:blue;display:inline;  text-decoration:none;font-size:12px;">'.$row['date'].' @ &nbsp; '.$row['time'].'</h2><br/>
									';
								}
							?> 
						</li>
					</ul>
				</li>
				<li class="item3"><a href="joint.php"><img src="images/arrow.png" alt="">Chama Account</a>
					<ul>
						<li class="subitem1"><a href="chama.php"> <h2 style="color:blue;text-decoration:none;">Access Chama Account</h2></a></li>
						<li class="subitem2"><h2 style="color:blue;text-decoration:none;">Details</h2></li>
					</ul>
				</li>
			<!--	<li class="item4"><a href="#"><img src="images/arrow.png" alt="">Helpful Links</a>
					<ul>
					    <li class="subitem2"><a href="#"> </a></li>
						<li class="subitem3"><a href="#"></a></li>
					</ul>
				</li>
				<li class="item5"><a href="#"><img src="images/arrow.png" alt="">Make A Gift</a>
					<ul>
						<li class="subitem1"><a href="#"></a></li>
						<li class="subitem2"><a href="#"> </a></li>
						<li class="subitem3"><a href="#"> </a></li>
					</ul>
				</li>
	 		</ul>-->
				</div>
		
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
				</div>
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
					<p>© 2015 benki .   <a href="#" target="_blank"></a> </p>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--footer-end-->	
</body>
</html>
