<?php include('fragments/header.php');?>
	<section class="main">
		<div class="wrapp">
			<div class="mensaje">
				<h1>Bienvenido!</h1>
			</div>
			
			<?php
				include('clases/Utilities.php');
				$db = Utilities::getConnection();
				if(isset($_POST['submit']))
				{
				  mod_user();
				} 

				function mod_user(){
						
					
					if(!(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["gender"])))
					{

						$array = array($_POST["name"],$_POST["gender"],$_POST["email"],$_POST["password"],$_POST["website"],date("Y-m-d h:i:sa") ,0,
							(int)$_GET["id"]);	
						
						$result = $GLOBALS["db"]->modificarUsuario($array);
						if($result){
							$_POST = array();
							header("Location:consult_user.php");
							exit();
						}
						var_dump($result);exit();
					}
						
					
				}
				
				$nameErr = $emailErr = $genderErr = $websiteErr = $passwordErr ="";
				$id = $_GET["id"];
				$user = $db->getUsuario($id);
				$name = $user["nombre"];
				$email = $user["correo"];
				$gender =$user["sexo"];
				$comment =""; 
				$website = $user["web"];
				$password = $user["clave"];

			?>
 
			<div class="contenido">
				<h2>Sing up</h2>
				<p><span class="error">* required field.</span></p>
				<form method="post" action="<?php 
									echo $_SERVER['PHP_SELF'].'?id='.$_GET['id'].' '; 
								?>">  
				  Name: <input type="text" name="name" value="<?php echo $name;?>">
				  <span class="error">* <?php echo $nameErr;?></span>
				  <br><br>
				  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
				  <span class="error">* <?php echo $emailErr;?></span>
				  <br><br>
				  Password: <input type="password" name="password" value="<?php echo $password;?>">
				  <span class="error">* <?php echo $passwordErr;?></span>
				  <br><br>
				  Website: <input type="text" name="website" value="<?php echo $website;?>">
				  <span class="error"><?php echo $websiteErr;?></span>
				  <br><br>
				  Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
				  <br><br>
				  Gender:
				  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
				  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
				  <span class="error">* <?php echo $genderErr;?></span>
				  <br><br>
				  <input type="submit" name="submit" value="GRABAR">  
				</form>
			</div>
			<?php include('fragments/options.php');?>
		</div>
	</section>
	<?php include("fragments/footer.php");?>
</body>
</html>