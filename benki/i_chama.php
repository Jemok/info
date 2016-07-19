<?php
session_start();
include_once 'includes/dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: http://localhost/benki/index.php");
}

$chama_id=base64_decode($_GET['id']);
$resq=mysql_query("SELECT * FROM tbl_chama WHERE chama_id='$chama_id' ")or die(mysql_error());
if($row= mysql_fetch_array($resq))
{
	$chama_name=$row['chama_name'];
	$created_by=$row['created_by'];
}
$var=$_SESSION['user'];

//Remove member from group
if(isset($_POST['delete_member']))
{
	$member_id=filter_input(INPUT_POST, 'member_id', FILTER_SANITIZE_STRING);
	$res=mysql_query("UPDATE tbl_users SET ref_chama='' WHERE user_id='$member_id' ")or die(mysql_error());
	if($res)
	{
		?>
			<script>
				alert("Success: Member removed from group Successfully");
				window.location.replace("http://localhost/benki/i_chama.php?<?php echo' id='.base64_encode($chama_id).' ' ?>");
			</script>
		<?php
	}
	else
	{
		?>
			<script>
				alert("Error: Member could not be removed from group...please try again later");
				window.location.replace("http://localhost/benki/i_chama.php?<?php echo' id='.base64_encode($chama_id).' ' ?>");
			</script>
		<?php
	}
}

//Add member to group
if(isset($_POST['add_member']))
{
	$member_id=filter_input(INPUT_POST, 'member_id', FILTER_SANITIZE_STRING);
	$res=mysql_query("UPDATE tbl_users SET ref_chama='$chama_id' WHERE user_id='$member_id' ")or die(mysql_error());
	if($res)
	{
		?>
			<script>
				alert("Success: Member added to group Successfully");
				window.location.replace("http://localhost/benki/i_chama.php?<?php echo' id='.base64_encode($chama_id).' ' ?>");
			</script>
		<?php
	}
	else
	{
		?>
			<script>
				alert("Error: Member could not be added to group...please try again later");
				window.location.replace("http://localhost/benki/i_chama.php?<?php echo' id='.base64_encode($chama_id).' ' ?>");
			</script>
		<?php
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Chama | <?php echo $chama_name;?></title>
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
<style>
	.display_members
	{
		background:#fff;
		width:50%
		height:auto;
	}
	.display_members caption
	{
		background:#000;
		color:#fff;
		padding:5px;
		text-align:center;
		font-size:14px;
		font-family:Trebuchet MS;
	}
	.display_members td
	{
		padding:5px;
		font-family:Trebuchet MS;
		color:#707070;
	}
	
	.add_members
	{
		background:#707070;
		width:50%
		height:auto;
		float:left;
	}
	.add_members caption
	{
		width:100%;
		background:#000;
		color:#fff;
		padding:5px;
		text-align:center;
		font-size:14px;
		font-family:Trebuchet MS;
	}
	.add_members td
	{
		padding:5px;
		font-family:Trebuchet MS;
		color:#000;
	}
</style>		
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
			<h2><?php echo $chama_name;?></h2>
		</div>
		<table class="display_members">
			<caption>EXISTING <?php echo strtoupper($chama_name);?> MEMBERS</caption>
			<tr>
				<td>#</td>
				<td>Member Full Names</td>
				<td>Actions</td>
			</tr>
			<?php
				$resq1=mysql_query("SELECT user_id,full_names FROM tbl_users WHERE ref_chama='$chama_id' AND user_id !='$var' ")or die(mysql_error());
				$tally=1;
				while($row1= mysql_fetch_array($resq1))
				{
					$full_names=$row1['full_names'];
					$user_id=$row1['user_id'];
					
					//Check if its the owner of the group
					if($created_by==$var)
					{
						?>
							<form method="post">
								<tr>
									<td><?php echo $tally; ?></td>
									<td><?php echo $full_names; ?><input type="hidden" name="member_id" value="<?php echo $user_id; ?>" /></td>
									<td><button name="delete_member" title="Remove member from group" style="width:30px; height:30px; cursor:pointer; background:url(images/cancel.png) center no-repeat; border:none; "></button></td>
								</tr>
							</form>
						<?php
					}
					else
					{
						?>
							<form method="post">
								<tr>
									<td><?php echo $tally; ?></td>
									<td><?php echo $full_names; ?></td>
									<td></td>
								</tr>
							</form>
						<?php
					}
					$tally=$tally+1;
				}
			?>
		</table>
		<br/>
		<br/>
		<table class="add_members">
			<caption><a href="http://localhost/benki/register_members.php">ADD NEW MEMBERS</a></caption>
		<?php
			/*Check if its the owner of the group
			if($created_by==$var)
			{
				$resq1=mysql_query("SELECT user_id,full_names FROM tbl_users WHERE ref_chama='' ")or die(mysql_error());
				$tally=1;
				while($row1= mysql_fetch_array($resq1))
				{
					$full_names=$row1['full_names'];
					$user_id=$row1['user_id'];
					//Check if its the owner of the group
					?>
						<form method="post">
							<tr>
								<td><?php echo $tally; ?></td>
								<td><?php echo $full_names; ?><input type="hidden" name="member_id" value="<?php echo $user_id; ?>" /> </td>
								<td><button name="add_member" title="Add Member to group" style="width:30px; height:30px; cursor:pointer; background:url(images/accept.png) center no-repeat; border:none; "></button></td>
							</tr>
						</form>
					<?php
					$tally=$tally+1;
				}
			}*/
		?>
		</table>
	</div>
</div>	
</body>
</html>
