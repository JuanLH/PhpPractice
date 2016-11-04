<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("./Vistas/Shared/Cabezera.php"); ?>
    <title>Valoracion Robert Marcelino</title>
</head>

<body>

    <div id="wrapper">
        <?php 
            include("Vistas/Shared/Header.php"); 
            include("Script/database.php");
            $conexion = db_conectar();
            $codigo="";
            $descripcion="";
            if(isset($_POST["editar"])){
                $codigo=$_POST["codigo"];
                $descripcion = $_POST["nombre"];
            }
            if(isset($_POST["eliminar"])){
                $codigo=$_POST["codigo"];
                $query = db_ejecutar($conexion,"delete from pais where codigo_pais =".$codigo);
                $codigo ="";
            }
            if(isset($_POST["crear"])){
                $nombre=$_POST["nombre"];
                $query = "insert into pais (nombre) values ('".$nombre."')";
                if($query!="")
                {
                    $result = db_ejecutar($conexion,$query);
                }
                $query ="";
                $nombre = "";
            }
        ?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- form -->
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2">
                        <h1>Paises</h1>
                        <form role="form" method="POST" action="">
                            <div class="form-group input-group">
                                <span class="input-group-addon">Codigo</span>
                                <input class="form-control" value="<?php echo $codigo; ?>" type="numeric">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon">Nombre</span>
                                <input class="form-control" name="nombre" value="<?php echo $descripcion; ?>" type="text">
                            </div>
                            <div class="form-group input-group">
                                <input type="submit" name="crear" class="btn btn-success" value="Guardar">
                                <input type="buttom" name="limpiar" class="btn btn-warning" value="Limpiar">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Lista-->
                <div class="row">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Funciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                $query = db_ejecutar($conexion,"select * from pais");
                                if (sqlsrowscount($conexion,"select * from pais")<1) {
                                    echo"No existen registros";
                                }
                                else{
                                    while($row = sqlsrv_fetch_array($query)){
                                        echo '<tr>';
                                            echo '<td>'.$row["codigo_pais"].'</td>';
                                            echo '<td>'.$row["nombre"].'</td>'; 
                                            echo '<form method="POST" action="">';
                                                echo '<td>
                                                        <input type="hidden" name="codigo" value="'.$row["codigo_pais"].'">
                                                        <input type="hidden" name="nombre" value="'.$row["nombre"].'">
                                                        <input type="submit" name="editar" value="Editar" class="btn btn-link">';
                                            echo '</form>';
                                            echo '<form method="POST" action="">
                                                        <input type="hidden" name="codigo" value="'.$row["codigo_pais"].'">
                                                        <input type="submit" name="eliminar" value="eliminar" class="btn btn-link">
                                                    </td>';
                                            echo '</form>';
                                            echo '</tr>';
                                        
                                    }    
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>