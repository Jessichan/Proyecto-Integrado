<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>Administracion</title>
    <link rel="stylesheet" href="css/administracion.css">
</head>
<body>
	<?php
        include_once "conec.php";

        file_exists("database.php") ? include_once "database.php" : header('Location: index.php');

        connecBD(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        session_start();

        //si no estas logueado redirecciona a login
      	$nombreusu = "";
        if(!isset($_SESSION['iduser'])){
      		header('Location: /php/proyecto/login.php');
        }

        if(isset($_POST["desloguear"])){
            session_destroy();
            header('Location: /php/proyecto/index.php');
        }

        //evitar que administrador acceda a paginas de usuario
        if(isset($_SESSION["iduser"])){
                if($_SESSION["tipouser"] != "Admin"){
                    session_destroy();
                    header('Location: login.php');
                }
        }else
            header('Location: login.php');

        if(isset($_SESSION["iduser"])){

      	    // Consigue nombre de usuario
            $nombreusu = "SELECT nombre
                         FROM cliente
                         WHERE idcliente = {$_SESSION['iduser']};
                        ";

            if ($result = $connection->query($nombreusu)) {
                if ($result->num_rows > 0)
                    $nombreusu = $result->fetch_object()->nombre;
                else
                    echo "No se ha encontrado el nombre de usuario";
            }else
                echo "Wrong Query";
        }
 	?>



    <div id="caja">
        <form method="post" id="Desconectar">
            <input type="submit" name="desloguear" value="Desconectar">
        </form>
        <?php echo "<p id='saludo'> Hola, $nombreusu</p>" ?>
    </div>
 	<div id="uno">
		<a href='adcliente.php'><img src='img/clientes.png' /></a>
	</div>
	<div id="dos">
		<a href='adanimal.php'><img src='img/animales.png' width="220"px height="230"px/></a>
	</div>
	<div id="tres">
		<a href='adaccesorio.php'><img src='img/accesorios.png' width="230"px height="230"px/></a>
	</div>
	<div id="cuatro">
		<a href='adtienealquiler.php'><img src='img/alquiler.png' width="230"px height="230"px/></a>
	</div>
	<div id="cinco">
		<a href='adcompra.php'><img src='img/compra.png' width="210"px height="210"px/></a>
	</div>

	<p id="cliente">Clientes</p>
	<p id="animales">Animales</p>
	<p id="accesorios">Accesorios</p>
	<p id="tienealquiler">Tiene Alquiler</p>
	<p id="compra">Compra</p>
</body>
</html>