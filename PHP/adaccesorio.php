<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GETTING DATA FROM A MYSQL DATABASE</title>
    <link rel="stylesheet" href="css/adaccesorio.css">
</head>
<body>
    <?php
       include_once "conec.php";

        file_exists("database.php") ? include_once "database.php" : header('Location: index.php');

        connecBD(DB_HOST, DB_USER, DB_PASS, DB_NAME);

       session_start();

       changeTheme();

        //no entrar en nada si no estas logueado

       if(!isset($_SESSION['iduser'])){
            header('Location: /php/proyecto/login.php');
        }

        if(isset($_POST["desloguear"])){
            session_destroy();
            header('Location: /php/proyecto/index.php');
        }

        //evitar que usuario user acceda a paginas de admin
        if(isset($_SESSION["iduser"])){
            if($_SESSION["tipouser"] != "Admin"){
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

        //MAKING A SELECT QUERY
        /* Consultas de selección que devuelven un conjunto de resultados */
        if ($result = $connection->query("SELECT * FROM accesorio;")) {

            if ($result){
                /* PRINT THE TABLE AND THE HEADER */
                echo "<table style='border:1px solid black;'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>Idaccesorio</th>";
                            echo "<th>Nombre</th>";
                            echo "<th>Descripcion</th>";
                            echo "<th>Cantidad</th>";
                            echo "<th>Precio</th>";
                            echo "<th>Imagen</th>";
                            echo "<th>Modificar</th>";
                            echo "<th>Borrar</th>";
                        echo "</tr>";
                    echo "</thead>";
            }

            //FETCHING OBJECTS FROM THE RESULT SET
            //THE LOOP CONTINUES WHILE WE HAVE ANY OBJECT (Query Row) LEFT
                while($obj = $result->fetch_object()) {
                    //PRINTING EACH ROW
                        echo "<tr>";
                        echo "<td>".$obj->idaccesorio."</td>";
                        echo "<td>".$obj->nombre."</td>";
                        echo "<td>".$obj->descripcion."</td>";
                        echo "<td>".$obj->cantidad."</td>";
                        echo "<td>".$obj->precio."</td>";
                        echo "<td>".$obj->imagen."</td>";
                        echo "<td><a href='editaraccesorio.php?id=".$obj->idaccesorio."'><img src='img/modificar.jpg' width='15px'height='15px'/></a></td>";
                        echo "<td><a href='borraraccesorio.php?id=".$obj->idaccesorio."'><img src='img/borrar.png' width='15px' height='15px'/></a></td>";
                    echo "</tr>";
                }

            //Free the result. Avoid High Memory Usages
            $result->close();
            unset($obj);
            unset($connection);
        }
                echo "</table>";
    ?>

    <input type="button" onclick=" location.href='/php/proyecto/agregaraccesorio.php' " value="Añadir Accesorio" style=cursor:pointer; name="boton" />
    <input type="button" onclick=" location.href='/php/proyecto/administracion.php' " value="Administración" style=cursor:pointer; name="boton1" />

    <form method="post" id="Desconectar">
        <input type="submit" name="desloguear" value="Desconectar">
    </form>
</body>
</html>