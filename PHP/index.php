<?php
    // Archivo que se crea despues de la instalacion
    if(file_exists("database.php")){

    	//Borra el archivo install cuando entras en el index.php
      	if(file_exists("install.php"))
        	unlink("install.php");

        header('Location: login.php');
    }else
        header('Location: install.php');
?>