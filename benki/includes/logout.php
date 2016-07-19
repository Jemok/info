<?php
session_start();

if(!isset($_SESSION['user']))
{
	header("Location: http://localhost/benki/index.php");
}
else if(isset($_SESSION['user'])!="")
{
	header("Location: http://localhost/benki/home.php");
}

if(isset($_GET['logout']))
{
	session_destroy();
	unset($_SESSION['user']);
	header("Location: http://localhost/benki/index.php");
}
?>