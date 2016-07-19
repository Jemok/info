<style>
	.search_results 
	{
		width:100%;
		height:auto;
		padding:5px;
		margin:0 auto;
		background:#E0E0E0;
	}
	.search_results li
	{
		color:blue;
		padding:5px;
		font-family:"Trebuchent"
		font-size:14px;
		display:inline;
		margin:5px;
	}
</style>
<?php
	error_reporting(0);
	if(isset($_POST['search_term']))
	{
		$search_term = mysql_real_escape_string($_POST['search_term']);
		$res=mysql_query("	SELECT user_id, full_names FROM tbl_users WHERE user_id LIKE  '%$search_term%' OR full_names LIKE '%$search_term%'
							UNION ALL
							SELECT chama_id, chama_name FROM tbl_chama WHERE chama_id LIKE '%$search_term%' OR chama_name LIKE '%$search_term%' ")or die(mysql_error());
		if(mysql_num_rows($res)>0)
		{
			echo'
			<ul class="search_results">
				<li style="color:gray;"> SEARCH RESULTS FOR "<i>'.$search_term.'</i>"</li><br/><br/>';
					while($row=mysql_fetch_array($res))
					{
						echo ' <li>ID:</li><li>'.$row['user_id'].'</li> ';
						echo ' <li>FULL NAMES:</li><li>'.$row['full_names'].'</li> <br/>';	
					}
			echo'</ul>';
		}
		else
		{
			echo'
			<ul class="search_results">
				<li style="color:gray;"> SORRY! NO SEARCH RESULTS FOR "<i>'.$search_term.'</i>"</li><br/>';
			echo'</ul>';

		}
	}
	
?>