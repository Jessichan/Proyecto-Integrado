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
	    	if($_POST['cambiarcolor'] == "Rosa")      	$_SESSION["temaUsuario"] = "Rosa";
	      	else if($_POST['cambiarcolor'] == "Violeta")  $_SESSION["temaUsuario"] = "Violeta";
	      	else if($_POST['cambiarcolor'] == "Morado")  	$_SESSION["temaUsuario"] = "Morado";
	    }
	    changeTheme();

	 ?>
	<div id="caja">
            <h2>Colores</h2>
            <form method='post'>
                <label>
                  <input id="color4" type="radio" name="cambiarcolor" value="Rosa">Rosa
                </label>
                <label>
                  <input id="color5" type="radio" name="cambiarcolor" value="Violeta">Violeta
                </label>
                <label>
                  <input id="color6" type="radio" name="cambiarcolor" value="Morado">Morado
                </label>
                <input id="cambiar" type='submit' name="theme" value="Cambiar">
            </form>
            <input id="volver" type="submit" onclick=" location.href='/php/proyecto/administracion.php' " value="Volver" style=cursor:pointer; />
    </div>
</body>
</html>