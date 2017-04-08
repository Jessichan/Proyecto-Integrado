<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar</title>
    <link rel="stylesheet" type="text/css" href="css/borrar.css ">
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

        //evitar que usuario user acceda a paginas de admin
        if(isset($_SESSION["iduser"])){
            if($_SESSION["tipouser"] != "Admin"){
                session_destroy();
                header('Location: login.php');
            }
        }else
            header('Location: login.php');


        if (!empty($_GET)) {
                $id="";

            if (!empty($_GET['id']))
                $id=$_GET['id'];



            /* Consultas de selección que devuelven un conjunto de resultados */
            $result = $connection->query("DELETE FROM alquiler where Idalquiler=$id");
        }
    ?>

    <echo><p>Alquiler Borrado</p></echo>

    <form method="post">
        <input id="volver" type="button" onclick=" location.href='/php/proyecto/adtienealquiler.php' " value="Volver" style=cursor:pointer; name="boton" />
    </form>
</body>
</html>