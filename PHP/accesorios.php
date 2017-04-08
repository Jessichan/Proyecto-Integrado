<!DOCTYPE html>
<html>
<head>
	<title>Accesorios</title>
	<link rel="stylesheet" href="css/accesorios.css">
</head>
<body>

 	<?php
		include_once "conec.php";

        file_exists("database.php") ? include_once "database.php" : header('Location: index.php');

        connecBD(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	    session_start();

       if(!isset($_SESSION['iduser'])){
            header('Location: /php/proyecto/login.php');
        }

        if(isset($_POST["desloguear"])){
            session_destroy();
            header('Location: /php/proyecto/index.php');
        }

        //evita que usuario acceda a paginas de admin
        if(isset($_SESSION["iduser"])){
                if($_SESSION["tipouser"] != "User"){
                    session_destroy();
                    header('Location: login.php');
                }
        }else
            header('Location: login.php');

        if(isset($_SESSION["iduser"])){
      	     $nombreusu = "";

      		// Consigue nombre de usuario
            $nombreusu = "SELECT nombre
                         FROM cliente
                         WHERE idcliente = {$_SESSION['iduser']}
                        ";

            if ($result = $connection->query($nombreusu)) {
                    if ($result->num_rows > 0)
                        $nombreusu = $result->fetch_object()->nombre;
                    else
                        echo "No se ha encontrado el nombre de usuario";
            }else
                echo "Wrong Query";


  			// coger datos de los animales
            $idacces     = [];
			$nombreacces = [];
			$precioacces = [];
			$imagenacces = [];

            $cogeracce = "SELECT * FROM accesorio;";


            if ($result = $connection->query($cogeracce)) {
                    if ($result->num_rows > 0){
                	       while($accesorio = $result->fetch_object()){
                                array_push($idacces, $accesorio->idaccesorio);
                		        array_push($nombreacces, $accesorio->nombre);
                		        array_push($precioacces, $accesorio->precio);
                		        array_push($imagenacces, $accesorio->imagen);
                	        }
                    }else
                        echo "No se ha encontrado accesorio";
            }else
                echo "Query fallida";
		}else
			header('Location: /php/proyecto/login.php');
	?>

	<img id="enca" src="/php/proyecto/img/porta.jpg">
    <div id="caja">
        <form method="post" id="Desconectar">
            <input type="submit" name="desloguear" value="Desconectar">
        </form>
        <?php echo "<p id=\"saludo\"> Hola, $nombreusu</p>" ?>
        <br>
        <input id="volver" type="button" onclick=" location.href='/php/proyecto/menu.php' " value="Volver" style=cursor:pointer; name="boton" />
		<div id="contenido">
			<?php
				for($i=0;$i<count($nombreacces);$i++){
                    echo "<a href='/php/proyecto/accesorioinfo.php?id=".$idacces[$i]."'>";
	    			    echo "<div class='accesorio' data-id='$idacces[$i]'>";
	    			        echo "<img src='".$imagenacces[$i]."'>";
	    			        echo "<h3>".$nombreacces[$i]."</h3>";
	    			        echo "<p>".$precioacces[$i]."€</p>";
	    			    echo "</div>";
                    echo "</a>";
				}
			?>
		</div>
    </div>
</body>
</html>