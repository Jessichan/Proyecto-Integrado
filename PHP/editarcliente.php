<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Modificar</title>
    <link rel="stylesheet" type="text/css" href="css/editarcliente.css">
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

       changeTheme();

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
            header("Location: adcliente.php");

        $idcliente = $_GET['id'];

        $clienteid;
        $clientenombre;
        $clienteapellido;
        $clientelefono;
        $clienteemail;
        $clienteusuario;
        $clientetipo;
        $clientepassword;

        if ($result = $connection->query("SELECT * FROM cliente WHERE idcliente = $idcliente")){
            // if ($result = $connection->query("SELECT * FROM cliente WHERE idcliente = 1")){

            if($result->num_rows > 0){
                $valor = $result->fetch_object();

                $clienteid       = $valor->idcliente;
                $clientenombre   = $valor->nombre;
                $clienteapellido = $valor->apellidos;
                $clientetelefono = $valor->telefono;
                $clienteemail    = $valor->email;
                $clienteusuario  = $valor->usuario;
                $clientetipo     = $valor->tipo;
                $clientepassword = $valor->password;
            }else
                echo "No clients found.";
        }else
            echo "<br><br>Query wrong.";

    ?>

    <form method="post">
        <fieldset>
            <legend><h3>Cliente</h3></legend>
            <span>Id:</span><input name="id" type="text" value="<?php echo $clienteid; ?>" maxlength="25" required readonly><br>
            <span>Nombre:</span><input name="nombre" type="text" value="<?php echo $clientenombre; ?>" maxlength="25" required><br>
            <span>Apellidos:</span><input name="ape" type="text" value="<?php echo  $clienteapellido; ?>" maxlength="50" required>
            <span>Telefono:</span><input name="tfono" type="tel" value="<?php echo $clientetelefono; ?>" pattern="[0-9]{9}" required>
            <span>Email:</span><input name="email" type="email" value="<?php echo $clienteemail; ?>" maxlength="100" required>
            <span>Usuario:</span><input name="user" type="text" value="<?php echo  $clienteusuario; ?>" maxlength="15" required><br>
            <span>Tipo:</span><input name="tipo" type="text" value="<?php echo  $clientetipo; ?>" maxlength="15" required><br>
            <span>Password:</span><input name="pass" type="text" value="<?php echo $clientepassword; ?>" maxlength="50"><br>
            <span><input id= "Modificar" type="submit" value="Modificar"></span><br>
            <span><input id="Volver" type="button" onclick=" location.href='/php/proyecto/adcliente.php' " value="Volver" style=cursor:pointer; name="boton" />
            </span>
        </fieldset>
    </form>

    <?php

        // Editar Clientes cuando se haya enviado por POST el ID
        if (isset($_POST['id'])) {

            $id        = $_POST['id'];
            $nombre    = $_POST['nombre'];
            $apellidos = $_POST['ape'];
            $telefono  = $_POST['tfono'];
            $email     = $_POST['email'];
            $usuario   = $_POST['user'];
            $tipo      = $_POST['tipo'];
            $password  = sha1($_POST['pass']);

            // 1. Eliminar
            if ($result = $connection->query("DELETE FROM cliente WHERE idcliente = $id;")){
                if ($result == false)
                    echo "error: imposible eliminar cliente";
            }else
                echo "consulta invalida";

            // 2. Agregar
            $consulta = "INSERT INTO cliente VALUES($id, '$nombre', '$apellidos', '$telefono', '$email', '$usuario', '$tipo', '$password');";

            $result = $connection->query($consulta);
            if (!$result)
                echo "Query Error";
        }
    ?>
</body>
</html>