<?php 
	session_start();
	if(isset($_SESSION["usuario"])){
		header("location:consult_user.php");
		exit;
	}
	if(isset($_POST["submit"])){
		include_once "clases/DbPDO.php";
		$db = new DbPDO("sqlsrv", "localhost", "1433", "luis", "root", "valoracion_online");
		$result = $db->login($_POST["user"],$_POST["pass"]);
		//var_dump($result,$_POST);
		//exit;
		if($result){

			$_SESSION["usuario"]=$result["codigo_usuario"];

			header("location:consult_user.php");
			exit;
		}else{
			header("location:login.php");
			exit;
		}
	}
?>

<?php include('fragments/header.php');?>
<section class="main">
		<div class="wrapp">
			<div class="mensaje">
				<h1>Bienvenido!</h1>
			</div>
 
			<div class="contenido">
				<form method="POST" action="login.php">
					User Name:<input name="user" type="text" value=""/><br><br>
					Password:<input name="pass" type="password" value=""/><br>
					<input name="submit" type="submit" value="entrar"/>
				</form>
			</div>	
		</div>
		<?php include("fragments/footer.php");?>	
	</body>
</html>	
