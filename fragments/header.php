<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Inicio</title>
	<link rel="stylesheet" href="styles/styles.css">
	<link rel="stylesheet" href="styles/tables.css">
	<link rel="stylesheet" href="styles/form.css">
</head>
<body>
	<header>
		<div class="wrapp">
			<div class="logo">
				<a href="#"><img src="../resources/reddit.png" alt="img"></a>
			</div>
			<nav>
				<ul>
					<li><a href="index.php">Inicio</a></li>
					<li><a href="login.php">Log in</a></li>
					<li><a href="consult_user.php">Lista de Usuarios</a></li>
					<!--<li><a href="contacto.html">Contacto</a></li>-->
					<?php
						if (!session_id()) {
							session_start();
						}
						if(isset($_SESSION["usuario"])){
							echo '<li><a href="salir.php">Salir</a></li>';
						}
					?>
				</ul>
			</nav>
		</div>
	</header>
