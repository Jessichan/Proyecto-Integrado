<!DOCTYPE html>
<html>
<head>
	<title>Ajustes</title>
	<link rel="stylesheet" href="css/ajustes.css">
	<script src="js/chart_google.js"></script>
	<script src="js/jspdf.js"></script>
</head>
<body>
	<?php
		include_once "conec.php";

		file_exists("database.php") ? include_once "database.php" : header('Location: index.php');
        connecBD(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		session_start();
        changeTheme();

        if(!isset($_SESSION['iduser'])){
            header('Location: /php/proyecto/login.php');
        }


        if(isset($_POST["desloguear"])){
            session_destroy();
            header('Location: /php/proyecto/index.php');
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

              //temas
			if(isset($_POST["theme"])){
				if($_POST['cambiarcolor'] == "Rojo")      	$_SESSION["temaUsuario"] = "Rojo";
				else if($_POST['cambiarcolor'] == "Negro")  $_SESSION["temaUsuario"] = "Negro";
				else if($_POST['cambiarcolor'] == "Amarillo")  	$_SESSION["temaUsuario"] = "Amarillo";
			}

			//pdf
			if(isset($_POST["pdf"])){
				$nombreUsuario         = "";
				$numTotalAlquileres    = 0;
				$numTotalCompras       = 0;
				$precioTotalAlquileres = 0;
				$precioTotalCompras    = 0;
				$precioTotal           = 0;

				// Dinero de alquileres: Alquiler - Tiene - Animal
				$consulta = "SELECT precio
							 FROM alquiler, tiene, animal
							 where alquiler.idalquiler = tiene.idalquiler and
								   animal.idanimal = tiene.idanimal and
								   idcliente = {$_SESSION['iduser']}
							";

				if ($result = $connection->query($consulta)) {
			        if ($result->num_rows > 0){
						while($r = $result->fetch_object()){
                            $precioTotalAlquileres += $r->precio;
                	    }
			        }else
			            echo "Imposible obtener el precio de los animales alquilados por el usuario";
				}else
			    	echo "Query fallida";

			    // Dinero de alquileres: Alquiler - Tiene - Animal
				$consulta = "SELECT precioTotal
							 FROM compra
							 where idcliente = {$_SESSION['iduser']}
							";

				if ($result = $connection->query($consulta)) {
			        if ($result->num_rows > 0){
						while($r = $result->fetch_object()){
                            $precioTotalCompras += $r->precioTotal;
                	    }
			        }else
			            echo "Imposible obtener el precio de los accesorios comprados por el usuario";
				}else
			    	echo "Query fallida";

			    // Guardar el precioTotal de las 2 consultas anteriores (alquiler + compras)
   				$precioTotal = $precioTotalAlquileres + $precioTotalCompras;

				// Conseguir nombre de usuario
				$conseguirNombreUsuario = "SELECT nombre
								  		   FROM cliente
								  		   WHERE idcliente = {$_SESSION['iduser']}
								 		  ";

				if ($result = $connection->query($conseguirNombreUsuario)) {
			        if ($result->num_rows > 0)
						$nombreUsuario = $result->fetch_object()->nombre;
			        else
			            echo "Imposible obtener el nombre de usuario";
				}else
			    	echo "Query fallida";

				// Nº total de alquileres
				$numAlquileres = "SELECT idalquiler
								  FROM alquiler
								  WHERE idcliente = {$_SESSION['iduser']}
								 ";

				if ($result = $connection->query($numAlquileres)) {
		            if ($result->num_rows > 0)
		            	$numTotalAlquileres = $result->num_rows;
		            else
		                echo "El usuario no ha alquilado";
		    	}else
		        	echo "Query fallida";

			    // Nº total de productos comprados
				$numCompras = "SELECT idaccesorio
							   FROM compra
							   WHERE idcliente = {$_SESSION['iduser']}
						 	  ";

				if ($result = $connection->query($numCompras)) {
		            if ($result->num_rows > 0)
		            	$numTotalCompras = $result->num_rows;
		            else
		                echo "El usuario no ha realizado comopras";
		    	}else
		        	echo "Query fallida";

				// Conseguir fecha
				$currentDate = date('Y-m-d');

				echo "<script>
					  var doc = new jsPDF();
					  doc.setFontSize(32);
					  doc.setFontStyle('bold');
					  doc.setTextColor(185, 21, 21);
					  doc.text(20, 20, 'AnimalShop');

					  doc.setFontSize(16);
					  doc.text(20, 40, 'Informe de Actividad');
					  doc.setFontSize(14);
					  doc.text(80, 40, '$currentDate');

					  doc.setTextColor(0, 0, 0);
					  doc.setFontSize(12);
					  doc.text(20, 50, 'Usuario:');
					  doc.text(20, 55, 'Alquileres:');
					  doc.text(20, 60, 'Compras:');
					  doc.text(20, 65, 'Dinero de alquileres:');
					  doc.text(20, 70, 'Dinero de compras:');
					  doc.text(20, 75, 'Dinero total:');

					  doc.setFontStyle('normal');
					  doc.text(80, 50, '$nombreUsuario');
					  doc.text(80, 55, '$numTotalAlquileres');
					  doc.text(80, 60, '$numTotalCompras');
					  doc.text(80, 65, '$precioTotalAlquileres €');
					  doc.text(80, 70, '$precioTotalCompras €');
					  doc.text(80, 75, '$precioTotal €');

					  doc.save('animalshop_informe.pdf');
					  </script>";
				}
				changeTheme();
		}else
			header('Location: /php/proyecto/login.php');

	?>
	<div id="caja">
		<h2>Colores</h2>
		<form method='post'>
			<label>
				<input id="color1" type="radio" name="cambiarcolor" value="Rojo">Rojo
			</label>
			<label>
				<input id="color2" type="radio" name="cambiarcolor" value="Negro">Negro
			</label>
			<label>
				<input id="color3" type="radio" name="cambiarcolor" value="Amarillo">Amarillo
			</label>
				<input id="cambiar" type='submit' name="theme" value="Cambiar">
		</form>
			<input id="volver" type="submit" onclick=" location.href='/php/proyecto/menu.php' " value="Volver" style=cursor:pointer; />
			<h2>Actividad De Usuario</h2>
			<div id="piechart"></div><br>
		<form method='post'>
        	<input id="botonpdf" type="submit" class="flatButton" name="pdf" value="Exportar informe pdf">
        </form>
	</div>

	<?php
		//grafica
		// Precio total gastado por el usuario
		$numTotalAlquileres = 0;
		$numTotalCompras = 0;

		// Nº total de alquileres
		$numAlquileres = "SELECT idalquiler
						  FROM alquiler
						  WHERE idcliente = {$_SESSION['iduser']}
						 ";

		if ($result = $connection->query($numAlquileres)) {
            if ($result->num_rows > 0)
            	$numTotalAlquileres = $result->num_rows;
            else
                echo "El usuario no ha alquilado";
    	}else
        	echo "Query fallida";

	    // Nº total de productos comprados
		$numCompras = "SELECT idaccesorio
					   FROM compra
					   WHERE idcliente = {$_SESSION['iduser']}
				 	  ";

		if ($result = $connection->query($numCompras)) {
            if ($result->num_rows > 0)
            	$numTotalCompras = $result->num_rows;
            else
                echo "El usuario no ha realizado comopras";
    	}else
        	echo "Query fallida";

	?>
	<script>
    // variables grafica
    var numTotalAlquileres = <?php echo json_encode($numTotalAlquileres); ?>;
    var numTotalCompras = <?php echo json_encode($numTotalCompras); ?>;

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

    	if(numTotalAlquileres == 0 && numTotalCompras == 0){
    		var data = google.visualization.arrayToDataTable([
    			['Task', 'Hours per Day'],
    			['No data', 1]
    			]);
    	}else{
    		var data = google.visualization.arrayToDataTable([
    			['Task', 'Hours per Day'],
    			['Cantidad total de alquileres', numTotalAlquileres],
    			['Cantidad total de compras', numTotalCompras]
    			]);
    	}
    	var options = {
        // title: 'Amounts of user'
    	};

    	var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    	chart.draw(data, options);
	}
	</script>

</body>
</html>