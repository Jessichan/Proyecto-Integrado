<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar cliente</title>
    <link rel="stylesheet" type="text/css" href="css/agregarcompra.css ">
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
            <legend><h3>Nueva Compra</h3></legend>
            <span>Idcliente:</span><input type="integer" name="idcliente" maxlength="5" required><br>
            <span>Idaccesorio:</span><input type="integer" name="idaccesorio" maxlength="5" required><br>
            <span>Cantidad:</span><input type="integer" name="cantidad" maxlength="5" required><br>
            <span>Preciototal:</span><input type="decimal" name="preciototal" maxlength="4,2" required><br>
            <span><input id= "agregar" type="submit" value="Agregar"></span><br>
            <span><input id="volver" type="button" onclick=" location.href='/php/proyecto/adcompra.php' " value="Volver" style=cursor:pointer; name="boton" />
            </span>
        </fieldset>
    </form>

    <?php
        include_once "conec.php";

        file_exists("database.php") ? include_once "database.php" : header('Location: index.php');

        connecBD(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        session_start();

        changeTheme();

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


        if (isset($_POST["idcliente"])){

            $idcliente = $_POST['idcliente'];
            $idaccesorio = $_POST['idaccesorio'];
            $cantidad = $_POST['cantidad'];
            $preciototal = $_POST['preciototal'];

            $consulta = "INSERT INTO compra VALUES('$idcliente', '$idaccesorio', '$cantidad', '$preciototal');";

            $result = $connection->query($consulta);

            if (!$result)
                echo "Query Error";
        }
    ?>
</body>
</html>