<!DOCTYPE html>
<html>
<head>
	<title>Ajustes</title>
	<link rel="stylesheet" href="css/ajustes.css">
</head>
<body>
	<?php

		include_once "conec.php";
		session_start();

		if(isset($_POST["theme"])){
	    	if($_POST['cambiarcolor'] == "Rojo")      	$_SESSION["temaUsuario"] = "Rojo";
	      	else if($_POST['cambiarcolor'] == "Negro")  $_SESSION["temaUsuario"] = "Negro";
	      	else if($_POST['cambiarcolor'] == "Amarillo")  	$_SESSION["temaUsuario"] = "Amarillo";
	    }
	    changeTheme();

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
    </div>
</body>
</html>