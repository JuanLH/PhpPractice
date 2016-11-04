<?php include("protegida.php");?>
<?php include('fragments/header.php');?>
	<section class="main">
		<div class="wrapp">
			<div class="mensaje">
				<h1>Registro de Usuarios!</h1>
			</div>
 
			<div class="contenido" >
				<?php
					if(isset($_POST['submit']))
					{
					  getRow();
					} 

					function getRow(){

							echo "hello <br>";
					}
				?>
				
					<?php
						include_once "clases/DbPDO.php";
						$db = new DbPDO("sqlsrv", "localhost", "1433", "luis", "root", "valoracion_online");
						$result = $db->getUsuarios();
					?>
					<div class="wrapper">	
						<table>
						<th class="smallColumn" width="5">CODIGO</th>
						<th  >NOMBRE</th>
						<th  >GENERO</th>
						<th  >CORREO</th>
						<th  >CLAVE</th>
						<th  >WEB</th>	
						<th  ></th>	
						<?php			
							foreach($result as $row){
						?>
							<TR>
									<TD  class="smallColumn" width="5"><?=$row["codigo_usuario"] ?></TD>
								    <TD  ><?=$row["nombre"] ?></TD>
								    <TD  ><?=$row['sexo'] ?></TD>
								    <TD  ><?=$row['correo'] ?></TD>
								    <TD  ><?=$row['clave'] ?></TD>
								    <TD  ><?=$row['web'] ?></TD>
								    <TD><a href="mnt_usuario.php?id=<?php echo $row['codigo_usuario']?>">editar</a></TD>	
								    
							</TR>   	
						<?php              
							} //close foreach 
						?>
						</table>
				</div>
				
			</div>
			<?php include('fragments/options.php');?>
		</div>
	</section>
	<?php include("fragments/footer.php");?>
</body>
</html>