<?php 
session_start();

if($_SESSION['email']){	
	session_destroy();
	header("location:../index.php");
}
else{
	header("location:../index.php");
}
?>