<html>
<head>
    <meta charset="utf-8">
    <title>Editar</title>
    <link rel="stylesheet" type="text/css" href="css/editaranimal.css ">
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
            header("Location: adaccesorio.php");

        $idaccesorio = $_GET['id'];

        $accesorioid;
        $accesorionombre;
        $accesoriodescripcion;
        $accesoriocantidad;
        $accesorioprecio;
        $accesorioimagen;



        if ($result = $connection->query("SELECT * FROM accesorio WHERE idaccesorio = $idaccesorio")){


            if($result->num_rows > 0){
                $valor = $result->fetch_object();

                $accesorioid          = $valor->idaccesorio;
                $accesorionombre      = $valor->nombre;
                $accesoriodescripcion = $valor->descripcion;
                $accesoriocantidad    = $valor->cantidad;
                $accesorioprecio      = $valor->precio;
                $accesorioimagen      = $valor->imagen;

            }else
                echo "No accesorios encontrador.";
        }else
            echo "<br><br>Query wrong.";

    ?>

    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h3>Accesorio</h3></legend>
            <span>Id:</span><input name="id" type="text" value="<?php echo $accesorioid; ?>" maxlength="25" readonly required>
            <span>Nombre:</span><input name="nombre" type="text" value="<?php echo $accesorionombre; ?>" maxlength="500" required><br>
            <span>Descripcion:</span><input name="descripcion" type="text" value="<?php echo  $accesoriodescripcion; ?>" maxlength="500" required><br>
            <span>Cantidad:</span><input name="cantidad" type="text" value="<?php echo  $accesoriocantidad; ?>" maxlength="10" required><br>
            <span>Precio:</span><input name="precio" type="decimal" value="<?php echo  $accesorioprecio; ?>" maxlength="4,2" required><br>
            <span>Imagen:</span><input name="imagen" type="text" value="<?php echo  $accesorioimagen; ?>" maxlength="500"><br>
            <span><input id= "Modificar" type="submit" value="Modificar"></span><br>
            <span><input id="volver" type="button" onclick=" location.href='/php/proyecto/adaccesorio.php' " value="Volver" style=cursor:pointer; name="boton" />
            </span>
        </fieldset>
    </form>


    <?php

        // Editar Clientes cuando se haya enviado por POST el ID
        if (isset($_POST['id'])) {


            $id          = $_POST['id'];
            $nombre      = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $cantidad    = $_POST['cantidad'];
            $precio      = $_POST['precio'];
            $imagen      = $_POST['imagen'];

            // 1. Eliminar
            if ($result = $connection->query("DELETE FROM accesorio WHERE idaccesorio = $id")){
                if ($result == false)
                    echo "error: imposible eliminar accesorio";
            }else
                echo "consulta invalida";

            // 2. Agregar
            $consulta = "INSERT INTO accesorio VALUES($id, '$nombre', '$descripcion', '$cantidad', '$precio', '$imagen');";

            $result = $connection->query($consulta);
            if (!$result)
                echo "Query Error";
        }
    ?>
</body>
</html>