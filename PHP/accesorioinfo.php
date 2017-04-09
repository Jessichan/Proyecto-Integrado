<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Info de Accesorio</title>
    <link rel="stylesheet" href="css/accesorioinfo.css">
</head>
<body>
    <?php
        include_once "conec.php";

        file_exists("database.php") ? include_once "database.php" : header('Location: index.php');

        connecBD(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $precioAccesorioActual;

        session_start();

        changeTheme();

        if(!isset($_SESSION['iduser'])){
            header('Location: /php/proyecto/login.php');
        }


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
            $nombreusu = "";

            // Consigue nombre de usuario
            $nombreusu = "SELECT nombre
                          FROM cliente
                          WHERE idcliente = {$_SESSION['iduser']}
                         ";

            if ($result = $connection->query($nombreusu)) {
                    if ($result->num_rows > 0)
                        $nombreusu = $result->fetch_object()->nombre;
                else
                    echo "No se ha encontrado el nombre de usuario";
            }else
                echo "Wrong Query";
        }

        // Consigue el ID del animal y recoge su info
        $infoacces = "SELECT * FROM accesorio WHERE idaccesorio = {$_GET['id']};";

        if ($result = $connection->query($infoacces)) {
                if ($result){
                    $obj = $result->fetch_object();
                    echo "<div id='caja'>";
                        echo "<input type='submit' name='desloguear' value='Desconectar'>";
                        echo "<p id=saludo> Hola, $nombreusu</p>";
                        echo "<div id='foto'>";
                            echo "<p><img src='".$obj->imagen."' width='250px' height='250px'></p>";
                        echo "</div>";
                        echo "<div id='nombre'>";
                            echo "<h2><b> </b>".$obj->nombre."</h2>";
                        echo "</div>";
                        echo "<div id='descripcion'>";
                            echo "<p><b> </b>".$obj->descripcion."</p>";
                        echo "</div>";
                        echo "<div id='cantidad'>";
                            echo "<p><b> </b>".$obj->cantidad." Unidades</p>";
                        echo "</div>";
                        echo "<div id='precio'>";
                            echo "<h1><b> </b>".$obj->precio." €</h1>";
                        echo "</div>";
                    echo "</div>";
                    $precioAccesorioActual = $obj->precio;
                }else
                    echo "Imposible conseguir los datos";
        }else
            echo "Query Failed";

        if(isset($_POST['comprar'])){
            $insertar = "INSERT INTO compra
                         VALUES ({$_SESSION['iduser']}, {$_GET['id']}, 1, $precioAccesorioActual);
                        ";

            if ($result = $connection->query($insertar)) {
                if (!$result)
                    echo "Error al comprar accesorio (insertar en tabla compra).";
            }else
                echo "Consulta errónea";
        }
    ?>

    <input id="volver" type="button" onclick=" location.href='/php/proyecto/accesorios.php' " value="Volver" style=cursor:pointer; name="boton" />
    <form method="post">
        <input  id="comprar" type="submit" value="Comprar" style="cursor:pointer;" name="comprar" />
    </form>
</body>
</html>