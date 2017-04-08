<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar cliente</title>
    <link rel="stylesheet" type="text/css" href="css/agregarcliente.css ">
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
            <legend><h3>Nuevo Cliente</h3></legend>
            <span>Nombre:</span><input type="text" name="nombre" maxlength="25" required><br>
            <span>Apellidos:</span><input type="text" name="ape" maxlength="50" required><br>
            <span>Telefono:</span><input type="tel" name="tel" pattern="[0-9]{9}" required><br>
            <span>Email:</span><input type="email" name="email" maxlength="100" required><br>
            <span>Usuario:</span><input type="text" name="usu" maxlength="15" required><br>
            <span>Tipo:</span><select name="tipo"/>
                                    <option>Admin</option>
                                    <option>User</option>
                                </select required><br>
            <span>Pasword:</span><input type="text" name="pass" maxlength="50" required><br>
            <span><input id= "agregar" type="submit" value="Agregar"></span><br>
            <span><input id="volver" type="button" onclick=" location.href='/php/proyecto/adcliente.php' " value="Volver" style=cursor:pointer; name="boton" />
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

                $nombre  = $_POST['nombre'];
                $ape     = $_POST['ape'];
                $tel     = $_POST['tel'];
                $email   = $_POST['email'];
                $usu     = $_POST['usu'];
                $tipo    = $_POST['tipo'];
                $pass    = sha1($_POST['pass']);


      	   $consulta = "INSERT INTO cliente VALUES(NULL, '$nombre', '$ape', '$tel', '$email', '$usu', '$tipo', '$pass');";

      	   $result = $connection->query($consulta);

      	   if (!$result)
       		    echo "Query Error";
        }
    ?>
</body>
</html>