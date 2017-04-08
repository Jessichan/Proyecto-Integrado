<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Modificar</title>
     <link rel="stylesheet" type="text/css" href="css/editarcliente.css ">
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
            header("Location: adcompra.php");

        $idcliente = $_GET['id'];

        $compraidcliente;
        $compraidaccesorio;
        $compracantidad;
        $comprapreciototal;


        if ($result = $connection->query("SELECT * FROM compra WHERE idcliente = $idcliente")){

            if($result->num_rows > 0){
                $valor = $result->fetch_object();

                $compraidcliente   = $valor->idcliente;
                $compraidaccesorio = $valor->idaccesorio;
                $compracantidad    = $valor->cantidad;
                $comprapreciototal = $valor->preciototal;
            }else
                echo "No compras encontrados.";
        }else
            echo "<br><br>Query wrong.";

    ?>


    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h3>Compra</h3></legend>
            <span>Idcliente:</span><input name="idcliente" type="text" value="<?php echo $compraidcliente; ?>" maxlength="11" required><br>
            <span>Idaccesorio:</span><input name="idaccesorio" type="text" value="<?php echo $compraidaccesorio; ?>" maxlength="11" required><br>
            <span>Cantidad:</span><input name="cantidad" type="text" value="<?php echo  $compracantidad; ?>" required><br>
            <span>Precio Total:</span><input name="preciototal" type="decimal" value="<?php echo  $comprapreciototal; ?>" maxlength="4,2" required><br>
            <span><input id= "Modificar" type="submit" value="Modificar"></span><br>
            <span><input id="Volver" type="button" onclick=" location.href='/php/proyecto/adcompra.php' " value="Volver" style=cursor:pointer; name="boton" />
            </span>
        </fieldset>
    </form>

    <?php

        // Editar Clientes cuando se haya enviado por POST el ID
        if (isset($_POST['id'])) {


            $idcliente     = $_POST['id'];
            $idaccesorio   = $_POST['idaccesorio'];
            $cantidad      = $_POST['cantidad'];
            $preciototal   = $_POST['preciototal'];

            // 1. Eliminar
             if ($result = $connection->query("DELETE FROM compra WHERE idcliente = $id")){
                    if ($result == false)
                        echo "error: imposible eliminar compra";
             }else
                echo "consulta invalida";

            // 2. Agregar
            $consulta = "INSERT INTO compra VALUES($idcliente, '$idaccesorio', '$cantidad', '$preciototal');";

            $result = $connection->query($consulta);
            if (!$result)
                echo "Query Error";
        }
    ?>
</body>
</html>