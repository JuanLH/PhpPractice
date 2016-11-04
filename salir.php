<?php 
	session_start();
	if(isset($_SESSION["usuario"])){
		unset($_SESSION["usuario"]);
	}

	header("location:login.php");
		exit;
