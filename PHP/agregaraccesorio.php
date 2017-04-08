<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar accesorio</title>
    <link rel="stylesheet" type="text/css" href="css/agregaraccesorio.css">
    <style>
        span {
            width: 100px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h3>Nuevo Accesorio</h3></legend>
            <span>Nombre:</span><input type="text" name="nombre" maxlength="25" required><br>
            <span>Descripcion:</span><input type="text" name="descrip" maxlength="500" required><br>
            <span>Cantidad:</span><input type="text" name="cantidad" maxlength="10" required><br>
            <span>Precio:</span><input type="decimal" name="precio" maxlength="4,2" required><br>
            <span>Imagen:</span><input type="file" name="image"><br>
            <span><input id= "agregar" type="submit" value="Agregar"></span><br>
            <span><input id="volver" type="button" onclick=" location.href='/php/proyecto/adaccesorio.php' " value="Volver" style=cursor:pointer; name="boton" />
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


        if (isset($_POST["nombre"])){
            $tmp_file = $_FILES['image']['tmp_name'];
            $target_dir = "img/";
            $target_file = strtolower($target_dir . basename($_FILES['image']['name']));

            $valid = true;

            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $valid = false;
            }

            if($_FILES['image']['size'] > (2048000)) {
                $valid = false;
                echo 'Oops!  Your file\'s size is to large.';
            }

            $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
            if ($file_extension != "jpg" &&
                $file_extension != "jpeg" &&
                $file_extension != "png" &&
                $file_extension != "gif") {
                $valid = false;
                echo "Only JPG, JPEG, PNG & GIF files are allowed";
            }

            if ($valid) {
                move_uploaded_file($tmp_file, $target_file);

                $nombre = $_POST['nombre'];
                $descrip = $_POST['descrip'];
                $cantidad = $_POST['cantidad'];
                $precio = $_POST['precio'];



                $consulta = "INSERT INTO accesorio VALUES(NULL, '$nombre', '$descrip', '$cantidad', $precio, '$target_file');";

                $result = $connection->query($consulta);

                 if (!$result)
                     echo "Query Error";
            }

        }
    ?>
</body>
</html>