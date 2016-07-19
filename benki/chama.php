<?php
session_start();
include_once 'includes/dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: http://localhost/benki/index.php");
}
$res=mysql_query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['user'])or die(mysql_error());
$userRow=mysql_fetch_array($res);
if(isset($_POST['register_chama']))
{
	date_default_timezone_set('Africa/Nairobi');
	
	$date= date("d/m/Y");
	$time= date("h:i a");
	$var=$_SESSION['user'];
	$chama_id=filter_input(INPUT_POST, 'chama_id', FILTER_SANITIZE_STRING);
	$chama_name=filter_input(INPUT_POST, 'chama_name', FILTER_SANITIZE_STRING);
	$register_chama_password=filter_input(INPUT_POST, 'register_chama_password', FILTER_SANITIZE_STRING);
	$password=md5($register_chama_password);
	
	//Check if such a chama name or ID exists
	$ress=mysql_query("SELECT chama_id,chama_name FROM tbl_chama WHERE chama_id= '$chama_id' OR chama_name='$chama_name' ")or die(mysql_error());
	if(mysql_num_rows($ress)==0)
	{
		//Check if such a user exists
		$resa=mysql_query("SELECT password FROM tbl_users WHERE user_id='$var' AND password = '$password' ")or die(mysql_error());
		if(mysql_num_rows($resa)==1)
		{
			//Check if the user is already registered to a Chama
			$resq=mysql_query("SELECT ref_chama FROM tbl_users WHERE ref_chama='' AND user_id='$var' ")or die(mysql_error());
			if(mysql_num_rows($resq)==1)
			{
				$resb=mysql_query("	INSERT INTO tbl_chama (chama_id,chama_name,created_by,date,time) VALUES('$chama_id','$chama_name','$var','$date','$time') ")or die(mysql_error());
				$resc=mysql_query(" UPDATE tbl_users SET ref_chama='$chama_id' WHERE user_id='$var' ")or die(mysql_error());
				if($resb && $resc )
				{
					?>
						<script>
							alert("Success: Chama registration successful");
							window.location.replace("http://localhost/benki/chama.php");
						</script>
					<?php
				}
				else
				{
					?>
						<script>
							alert("Error: Chama was not regisered successfully");
							window.location.replace("http://localhost/benki/chama.php");
						</script>
					<?php
				}
			}
			else
			{
				?>
					<script>
						alert("Error: You are already a member of a Chama");
						window.location.replace("http://localhost/benki/chama.php");
					</script>
				<?php
			}
		}
		else
		{
			?>
				<script>
					alert("Error: Wrong Password");
					window.location.replace("http://localhost/benki/chama.php");
				</script>
			<?php
		}
	}
	else
	{
		?>
			<script>
				alert("Error: A Chama with that Name exists");
				window.location.replace("http://localhost/benki/chama.php");
			</script>
		<?php
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Chama | <?php echo $userRow['full_names'];?></title>
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
									$res=mysql_query("SELECT current_account FROM tbl_current_account WHERE ref_user=".$_SESSION['user'])or die(mysql_error());
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
                                        <li><a href="index.php">Home</a></li>
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
				<h2>Chama Account</h2>
			</div>
	<!--start-single-->
	<!--<div class="single contact">
		
				</div>-->
				<div class="tabs">
				<ul class="menu_drop">
				<li class="item1"><a href="#"><img src="images/arrow.png" alt="">Existing Chamas</a>
					<ul>
						<?php
							$res=mysql_query("SELECT chama_id,chama_name FROM tbl_chama" )or die(mysql_error());
							$tally=1;
							while( $row=mysql_fetch_array($res) )
							{
								$chama_id=$row['chama_id'];
								$chama_name=$row['chama_name'];
								
								echo'<li class="subitem1"><a href="i_chama.php?id='.base64_encode($chama_id).'"> <h2 style="color:blue;text-decoration:none;">'.$tally.'.&nbsp;'.$chama_name.'</h2> </a></li>';
								$tally=$tally+1;
							}
						?>
					</ul>
				</li>
				<li class="item2"><a href="#"><img src="images/arrow.png" alt="">Create a Chama account</a>
					<ul>
						<li class="subitem2" style="height:250px; margin-top:-30px; background:#fff;" >
							<div class="register-main" >
								<form style="background:#fff; height:auto;padding:10px;" class="col-md-6 account-left" method="post" >
									<input placeholder="Chama ID" name="chama_id" type="text" tabindex="1" readonly value="<?php $digits = 5; $user_id= rand(pow(10, $digits-1), pow(10, $digits)-1); echo $user_id; ?>" required >
									<input placeholder="Chama Name" name="chama_name" id="withdraw_date" type="text" tabindex="2" required>
									<input placeholder="Enter Password" name="register_chama_password" type="password" tabindex="4" required>
									<div class="clearfix"></div>
									<div class="address submit">
										<input type="submit" value="Register Chama" name="register_chama" > 
									</div>
								</form>
								
							</div> 
						</li>
					</ul>
				</li>
			<!--	<li class="item3"><a href="#"><img src="images/arrow.png" alt="">Reviews (10)</a>
					<ul>
						<li class="subitem1"><a href="#"></a></li>
						<li class="subitem2"><a href="#"> </a></li>
						<li class="subitem3"><a href="#"></a></li>
					</ul>
				</li>
				<li class="item4"><a href="#"><img src="images/arrow.png" alt="">Helpful Links</a>
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
	<div class="footer" style="bottom:0px;">
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
