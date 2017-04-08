<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <?php
        //Si no estas logueado ve a login
        if(!isset($_SESSION['iduser'])){
            header('Location: /php/proyecto/login.php');
        }

        //si presionas desconectar, te lleva al login
        if(isset($_POST["desloguear"])){
            session_destroy();
            header('Location: /php/proyecto/index.php');
        }

        //evita que usuario admin acceda a paginas de usuario
        if(isset($_SESSION["iduser"])){
                if($_SESSION["tipouser"] != "User"){
                    session_destroy();
                    header('Location: login.php');
                }
        }else
            header('Location: login.php');

        if(isset($_SESSION["iduser"])){
            $username = "";

            // Consigue nombre de usuario
            $nombreusu = "SELECT nombre
                         FROM cliente
                         WHERE idcliente = {$_SESSION['iduser']}
                        ";

            if ($result = $connection->query($nombreusu)) {
                    if ($result->num_rows > 0)
                        $nombreusuario = $result->fetch_object()->nombre;
                    else
                        echo "No se ha encontrado nombre de usuario";
            }else
                echo "Query fallida";
        }else
            header('Location: /php/proyecto/login.php');
    ?>

    <?php echo "<p id=\"saludo\"> Hola, $nombreusu</p>" ?>
</body>
</html>