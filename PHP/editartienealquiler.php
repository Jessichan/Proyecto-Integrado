<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Modificar</title>
    <link rel="stylesheet" type="text/css" href="css/editartienealquiler.css ">
    <style>
        span {
            width: 100px;
            display: inline-block;
        }
    </style>
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

        //evitar que administrador acceda a paginas de usuario
        if(isset($_SESSION["iduser"])){
            if($_SESSION["tipouser"] != "Admin"){
                session_destroy();
                header('Location: login.php');
            }
        }else
            header('Location: login.php');


        if(!$_GET['id'])
            header("Location: adtienealquiler.php");

        $idalquiler = $_GET['id'];

        $alquilerid;
        $alquilercliid;
        $alquilerfecha;

        //Pone id igual que id que le paso por variable y recoge su info
        if ($result = $connection->query("SELECT * FROM alquiler WHERE idalquiler = $idalquiler")){

            if($result->num_rows > 0){
                $valor = $result->fetch_object();

                $alquilerid = $valor->idalquiler;
                $alquilercliid = $valor->idcliente;
                $alquilerfecha = $valor->fecha;
            }else
                echo "No alquileres encontrados.";
        }else
            echo "<br><br>Query wrong.";

        $idalquiler = $_GET['id'];

        $tieneidalquiler;
        $tieneidanimal;
        $tienecantidad;

        //recoge info del id pasado por get
        if ($result = $connection->query("SELECT * FROM tiene WHERE idalquiler = $idalquiler")){

            if($result->num_rows > 0){
                $valor = $result->fetch_object();

                $tieneidalquiler  = $valor->idalquiler;
                $tieneidanimal    = $valor->idanimal;
                $tienecantidad    = $valor->cantidad;
            }else
                echo "No encontrado.";
        }else
            echo "<br><br>Query wrong.";


        if(isset($_POST['modificar'])){
            $idalquiler = $_POST['idalquiler'];
            $idcliente  = $_POST['idcliente'];
            $idanimal   = $_POST['idanimal'];
            $fecha      = $_POST['fecha'];
            $cantidad   = $_POST['cantidad'];


            //1. Eliminar
            if ($result = $connection->query("DELETE FROM alquiler WHERE idalquiler = $idalquiler")){
                if ($result == false)
                    echo "error: imposible eliminar";
            }else
                echo "consulta invalida";

            //2. agregar
            $consulta1 = "INSERT INTO alquiler VALUES($idalquiler, $idcliente, '$fecha');";
            $consulta2 = "INSERT INTO tiene VALUES($idalquiler, $idanimal, $cantidad);";

            if($result = $connection->query($consulta1)){
                if (!$result)
                    echo "Error: imposible insertar en la tabla alquiler";
            }else
                echo "Error en la consulta 1";

            if($result = $connection->query($consulta2)){
                if (!$result)
                    echo "Error: imposible insertar en la tabla tiene";
            }else
                echo "Error en la consulta 2";
        }

    ?>

    <form method="post">
        <fieldset>
            <legend><h3>TieneAlquiler</h3></legend>
            <span>Idalquiler:</span><input name="idalquiler" type="text" value="<?php echo $alquilerid; ?>"><br>
            <span>Idcliente:</span><input name="idcliente" type="text" value="<?php echo $alquilercliid; ?>"><br>
            <span>Idanimal:</span><input name="idanimal" type="text" value="<?php echo $tieneidanimal; ?>"><br>
            <span>Fecha:</span><input name="fecha" type="date" value="<?php echo  $alquilerfecha; ?>"><br>
            <span>Cantidad:</span><input name="cantidad" type="text" value="<?php echo  $tienecantidad; ?>"><br>
            <span><input id="Modificar" name="modificar" type="submit" value="Modificar"></span><br>
            <span><input id="Volver" type="button" onclick=" location.href='/php/proyecto/adtienealquiler.php' " value="Volver" style=cursor:pointer; name="boton" />
            </span>
        </fieldset>
    </form>
</body>
</html>