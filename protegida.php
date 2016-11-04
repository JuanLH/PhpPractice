<?php 
	session_start();
	if(isset($_SESSION["usuario"])){
		$id = $_SESSION["usuario"];
		include "clases/Utilities.php";
		$db = Utilities::getConnection();
		$user = $db->getUsuario($id);

		if(!$user){
			unset($_SESSION["usuario"]);
			header("location:login.php");
		}

	}
	else{
		header("location:login.php");
	}
	
?>