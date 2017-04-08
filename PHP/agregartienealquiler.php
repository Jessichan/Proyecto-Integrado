<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar cliente</title>
    <link rel="stylesheet" type="text/css" href="css/agregartienealquiler.css ">
    <style>
        span {
        width: 100px;
        display: inline-block;
        }
    </style>
</head>
<body>
    <form method="post">
        <fieldset>
            <legend><h3>Tiene Alquiler</h3></legend>
            <span>Idcliente:</span><input type="text" name="id" maxlength="50" required><br>
            <span>Fecha:</span><input type="date" name="fecha" maxlength="50" required><br>
            <span>Idanimal:</span><input type="integer" name="idanimal" maxlength="5" required><br>
            <span>Cantidad:</span><input type="integer" name="cantidad" maxlength="10" required><br>
            <span><input id= "agregar" type="submit" value="Agregar"></span><br>
            <span><input id="volver" type="button" onclick=" location.href='/php/proyecto/adtienealquiler.php' " value="Volver" style=cursor:pointer; name="boton" />
            </span>
        </fieldset>
    </form>

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


        //Conseguir id de tabla alquiler que se autoincrementa
        $alquilerID;
        if (isset($_POST["fecha"])){

            $idcliente = $_POST['id'];
            $fecha  = $_POST['fecha'];

            //Agregar datos en alquiler
            $consulta = "INSERT INTO alquiler VALUES(NULL , '$idcliente', '$fecha');";

            if($result = $connection->query($consulta)){
                if($result)
                    $alquilerID = $connection->insert_id;
                else
                    echo "Error al insertar a la tabla alquiler";
            }else
                echo "Query Error";
        }

        if (isset($_POST["idanimal"])){

            $idanimal   = $_POST['idanimal'];
            $cantidad   = $_POST['cantidad'];

            //Agregar en la tabla tiene
            $consulta = "INSERT INTO tiene VALUES('$idanimal', '$alquilerID', '$cantidad');";

           $result = $connection->query($consulta);

           if (!$result)
              echo "Query Error";
        }
    ?>
</body>
</html>