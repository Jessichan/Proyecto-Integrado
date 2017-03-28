<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GETTING DATA FROM A MYSQL DATABASE</title>
    <link rel="stylesheet" href="css/adtienealquiler.css">
</head>
<body>
    <?php

       include_once "conec.php";

       session_start();

        //no entrar en nada si no estas logueado

       if(!isset($_SESSION['iduser'])){
            header('Location: /php/proyecto/login.php');
        }

        if(isset($_POST["desloguear"])){
          session_destroy();
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
        if ($result = $connection->query("SELECT * FROM tiene, alquiler where tiene.idalquiler=alquiler.idalquiler;")) {

            if ($result){
            /* PRINT THE TABLE AND THE HEADER */
                echo "<table style='border:1px solid black;'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Idalquiler</th>";
                echo "<th>Idcliente</th>";
                echo "<th>Fecha</th>";
                echo "<th>Idalquiler</th>";
                echo "<th>Idanimal</th>";
                echo "<th>cantidad</th>";
                echo "<th>Modificar</th>";
                echo "<th>Borrar</th>";
                echo "</thead>";
                echo "</tr>";
            }

            //FETCHING OBJECTS FROM THE RESULT SET
            //THE LOOP CONTINUES WHILE WE HAVE ANY OBJECT (Query Row) LEFT
            while($obj = $result->fetch_object()) {
                //PRINTING EACH ROW
                echo "<tr>";
                echo "<td>".$obj->idalquiler."</td>";
                echo "<td>".$obj->idcliente."</td>";
                echo "<td>".$obj->fecha."</td>";
                echo "<td>".$obj->idalquiler."</td>";
                echo "<td>".$obj->idanimal."</td>";
                echo "<td>".$obj->cantidad."</td>";
                echo "<td><a href='editartienealquiler.php?id=".$obj->idalquiler."'><img src='img/modificar.jpg' width='15px'height='15px'/></a></td>";
                echo "<td><a href='borrartienealquiler.php?id=".$obj->idalquiler."'><img src='img/borrar.png' width='15px' height='15px'/></a></td>";
                echo "</tr>";
            }

            //Free the result. Avoid High Memory Usages
            $result->close();
            unset($obj);
            unset($connection);
        }
            echo "</table>";
    ?>

    <input type="button" onclick=" location.href='/php/proyecto/agregartienealquiler.php' " value="Añadir Tiene Alquiler" style=    cursor:pointer; name="boton" />
    <input type="button" onclick=" location.href='/php/proyecto/administracion.php' " value="Administración" style=cursor:pointer; name="boton1" />


    <form method="post" id="Desconectar">
        <input type="submit" name="desloguear" value="Desconectar">
    </form>
</body>
</html>