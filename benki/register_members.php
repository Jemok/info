<?php
	session_start();
	include_once 'includes/dbconnect.php';

	if(!isset($_SESSION['user']))
	{
		header("Location: http://localhost/benki/index.php");
	}
	?>
		<!DOCTYPE html>
		<html>
		<head>
			<title> Register Members</title>
			<link rel="stylesheet" type="text/css" href="style.css">
		</head>
		<script language="JavaScript" type="text/JavaScript">
		<!--
		function MM_jumpMenu(targ,selObj,restore)
		{ //v3.0
		  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		  if (restore) selObj.selectedIndex=0;
		}
		//-->
		</script>
		<body>
			<div id="container">
				<div class="report" style="width:30%;">
					<h1>REGISTER MEMBERS</h1>
					<br/>
					
						<form action="includes/insert_members.php" name="frmAdd" method="post">
							Select number of Records to insert : 
							<select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
								<?php
								for($i=1;$i<=50;$i++)
								{
									if($_GET["Line"] == $i)
									{
										$sel = "selected";
									}
									else
									{
										$sel = "";
									}
								?>
									<option value="<?php echo $_SERVER["PHP_SELF"];?>?Line=<?php echo $i;?>" <?php echo $sel;?>><?php echo $i;?></option>
								<?php
								}
								?>
							</select>
							<table style="width:100%;" >
								<tr>
									<th> <div align="center">Member Email </div></th>
								</tr>
							  <?php
							  @$line = $_GET["Line"];
							  if($line == 0){$line=1;}
							  for($i=1;$i<=$line;$i++)
							  {
								  ?>
								  <tr>
									<td><input type="text" name="member_no<?php echo $i;?>" size="20" placeholder="Email Address" style="border:none;width:92%;" required /></td>
								  </tr>
								  <?php
							  }
							  ?>
							</table>
							<input style="float:right;" type="submit" name="submit" value="submit">
							<input type="hidden" name="hdnLine" value="<?php echo $i;?>">
						</form>
					
					<br/>
					<ul>
						<li> <a href="http://localhost/benki/chama.php">1. << Back to Chamas <a/> </li>
					</ul>
				</div>
			</div>
		</body>
		</html>
	<?php
	
?>


