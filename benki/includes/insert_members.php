<?php
	session_start();
	include_once 'dbconnect.php';

	if(!isset($_SESSION['user']))
	{
		header("Location: http://localhost/benki/index.php");
	}
	$var=$_SESSION['user'];
	$resc=mysql_query("	SELECT users.user_id,users.ref_chama,chama.created_by 
						FROM tbl_users AS users 
						JOIN tbl_chama AS chama 
						ON users.user_id= chama.created_by
						WHERE users.user_id='$var' ")or die(mysql_error());
	if(mysql_num_rows($resc)>0)
	{
		if($row=mysql_fetch_array($resc))
		{
			$chama=$row['ref_chama'];
			for($i=1;$i<$_POST["hdnLine"];$i++)
			{
				if($_POST["member_no$i"] != "")
				{
					$strSQL = "UPDATE tbl_users SET ref_chama='$chama' WHERE email='".$_POST["member_no$i"]."' AND role !='1' ";
					$objQuery = mysql_query($strSQL);
					if($objQuery)
					{
						?>
							<script>
								alert("Success: Members added to Chama successfully");
								window.location.replace("http://localhost/benki/chama.php");
							</script>
						<?php
					}
					else
					{
						die(mysql_error());
					}
				}
				else
				{
					?>
						<script>
							alert("Error: All fields must be filled");
							window.location.replace("http://localhost/benki/register_members.php");
						</script>
					<?php
				}
			}
		}
	}
	else
	{
		?>
			<script>
				alert("Error: You dont have the priviledges to add new members");
				window.location.replace("http://localhost/benki/chama.php");
			</script>
		<?php
	}
?>