<html>
<head>
    <meta charset="utf-8">
    <title>Modificar</title>
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
            header("Location: adanimal.php");

        $idanimal = $_GET['id'];

        $animalid;
        $animalespecie;
        $animalnombre;
        $animalraza;
        $animaledad;
        $animaldescripcion;
        $animalprecio;
        $animalimagen;

        if ($result = $connection->query("SELECT * FROM animal WHERE idanimal = $idanimal")){

            if($result->num_rows > 0){
                $valor = $result->fetch_object();

                $animalid          = $valor->idanimal;
                $animalespecie     = $valor->especie;
                $animalnombre      = $valor->nombre;
                $animalraza        = $valor->raza;
                $animaledad        = $valor->edad;
                $animaldescripcion = $valor->descripcion;
                $animalprecio      = $valor->precio;
                $animalimagen      = $valor->imagen;
            }else
                echo "No animales encontrados.";
        }else
            echo "<br><br>Query wrong.";
    ?>


    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h3>Animal</h3></legend>
            <span>Id:</span><input name="id" type="text" value="<?php echo $animalid; ?>" maxlength="11" readonly required><br>
            <span>Especie:</span><input name="especie" type="text" value="<?php echo $animalespecie; ?>" maxlength="20" required><br>
            <span>Nombre:</span><input name="nombre" type="text" value="<?php echo  $animalnombre; ?>" maxlength="25" required><br>
            <span>Raza:</span><input name="raza" type="text" value="<?php echo $animalraza; ?>" maxlength="50" required><br>
            <span>Edad:</span><input name="edad" type="text" value="<?php echo $animaledad; ?>" maxlength="10" required><br>
            <span>Descripcion:</span><input name="des" type="text" value="<?php echo  $animaldescripcion; ?>" maxlength="500" required><br>
            <span>Precio:</span><input name="precio" type="decimal" value="<?php echo $animalprecio; ?>" maxlength="5,2" required><br>
            <span>Imagen:</span><input name="image" type="text" value="<?php echo $animalimagen; ?>" maxlength="50"><br>
            <span><input id= "Modificar" type="submit" value="Modificar"></span><br>
            <span><input id="Volver" type="button" onclick=" location.href='/php/proyecto/adanimal.php' " value="Volver" style=cursor:pointer; name="boton" />
            </span>
        </fieldset>
    </form>

    <?php

        // Editar Clientes cuando se haya enviado por POST el ID
        if (isset($_POST['id'])) {


            $id          = $_POST['id'];
            $especie     = $_POST['especie'];
            $nombre      = $_POST['nombre'];
            $raza        = $_POST['raza'];
            $edad        = $_POST['edad'];
            $descripcion = $_POST['des'];
            $precio      = $_POST['precio'];
            $imagen      = $_POST['image'];

            // 1. Eliminar
            if ($result = $connection->query("DELETE FROM animal WHERE idanimal = $id")){
                if ($result == false)
                    echo "error: imposible eliminar animal";
            }else
                echo "consulta invalida";

            // 2. Agregar
            $consulta = "INSERT INTO animal VALUES($id, '$especie', '$nombre', '$raza', '$edad', '$descripcion', '$precio', '$imagen');";

            $result = $connection->query($consulta);
            if (!$result)
                echo "Query Error";
        }
    ?>
</body>
</html>

