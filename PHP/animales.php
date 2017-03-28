<!DOCTYPE html>
<html>
<head>
	<title>Animales</title>
	<link rel="stylesheet" href="css/animales.css">
</head>
<body>

 	<?php
		include_once "conec.php";

	    session_start();

        if(!isset($_SESSION['iduser'])){
            header('Location: /php/proyecto/login.php');
        }


        if(isset($_POST["desloguear"])){
            session_destroy();
            header('Location: /php/proyecto/login.php');
        }


        //evita que usuario admin acceda a paginas de usuario
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
            $animalid     = [];
			$nombreanimal = [];
			$precioanimal = [];
			$imagenanimal = [];

            $cogeranimal = "SELECT * FROM animal;";


            if ($result = $connection->query($cogeranimal)) {
                    if ($result->num_rows > 0){
                	   while($animal = $result->fetch_object()){
                            array_push($animalid, $animal->idanimal);
                		    array_push($nombreanimal, $animal->nombre);
                		    array_push($precioanimal, $animal->precio);
                		    array_push($imagenanimal, $animal->imagen);
                	    }
                    }else
                        echo "No se ha encontrado animal";
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
				for($i=0;$i<count($nombreanimal);$i++){
	    		    echo "<a href='/php/proyecto/animalinfo.php?id=".$animalid[$i]."'>";
          	            echo "<div class='animal' data-id='$animalid[$i]'>";
	    		             echo "<img src='".$imagenanimal[$i]."'>";
	    		             echo "<h3>".$nombreanimal[$i]."</h3>";
	    		             echo "<p>".$precioanimal[$i]."€</p>";
                        echo "</div>";
                    echo "</a>";
				}
			?>
		</div>
    </div>
</body>
</html>