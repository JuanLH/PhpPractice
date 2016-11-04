<?php include('fragments/header.php');?>
	<section class="main">
		<div class="wrapp">
			<div class="mensaje">
				<h1>Bienvenido!</h1>
			</div>
 
			<div class="contenido">
				<?php 
				if(isset($_POST['submit']))
					{
					  insert_user();
					} 
										
					$nameErr = $emailErr = $genderErr = $websiteErr = $passwordErr ="";
					$name = $email = $gender = $comment = $website = $password = "";

					if ($_SERVER["REQUEST_METHOD"] == "POST") {
					  if (empty($_POST["name"])) {
					    $nameErr = "Name is required";
					  } else {
					    $name = test_input($_POST["name"]);
					    // check if name only contains letters and whitespace
					    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
					      $nameErr = "Only letters and white space allowed"; 
					    }
					  }
					  
					  if (empty($_POST["email"])) {
					    $emailErr = "Email is required";
					  } else {
					    $email = test_input($_POST["email"]);
					    // check if e-mail address is well-formed
					    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					      $emailErr = "Invalid email format"; 
					    }
					  }

					  if (empty($_POST["password"])) {
					    $passwordErr = "Password is required";
					  } else {
					    $password = test_input($_POST["password"]);
					  }

					    
					  if (empty($_post["website"])) {
					    $website = "";
					  } else {
					    $website = test_input($_POST["website"]);
					    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
					    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
					      $websiteErr = "Invalid URL"; 
					    }
					  }

					  if (empty($_POST["comment"])) {
					    $comment = "";
					  } else {
					    $comment = test_input($_POST["comment"]);
					  }

					  if (empty($_POST["gender"])) {
					    $genderErr = "Gender is required";
					  } else {
					    $gender = test_input($_POST["gender"]);
					  }
					}

					function test_input($data) {
					  $data = trim($data);
					  $data = stripslashes($data);
					  $data = htmlspecialchars($data);
					  return $data;
					}



					function insert_user(){
						
						include('clases/Utilities.php');
						if(!(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["gender"])))
						{
							$array = array($_POST["name"],$_POST["gender"],$_POST["email"],$_POST["password"],$_POST["website"],date("Y-m-d h:i:sa") ,0);	
							$db = Utilities::getConnection();
							$result = $db->registrarUsuario($array);
							//var_dump($result);exit();
							$_POST = array();

							  header("Location:consult_user.php");
							  exit();
							
						}
					}

					function update_user(){
						
						include('clases/Utilities.php');
						if(!(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["gender"])))
						{
							$array = array($_POST["name"],$_POST["gender"],$_POST["email"],$_POST["password"],$_POST["website"],date("Y-m-d h:i:sa") ,0);	
							$db = Utilities::getConnection();
							$result = $db->registrarUsuario($array);
							$_POST = array();

							  header("Location:consult_user.php");
							  exit();
							
						}
					}

				?>
				<h2>Sing up</h2>
				<p><span class="error">* required field.</span></p>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
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
