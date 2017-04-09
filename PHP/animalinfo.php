<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Info de Animal</title>
    <link rel="stylesheet" href="css/animalinfo.css">
</head>
<body>
    <?php
        include_once "conec.php";

        file_exists("database.php") ? include_once "database.php" : header('Location: index.php');

        connecBD(DB_HOST, DB_USER, DB_PASS, DB_NAME);

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
        $infoanimal = "SELECT * FROM animal WHERE idanimal = {$_GET['id']};";

        if ($result = $connection->query($infoanimal)) {
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
                            echo "<div id='raza'>";
                                echo "<p><b> </b>".$obj->raza."</p>";
                            echo "</div>";
                            echo "<div id='edad'>";
                                echo "<p><b> </b>".$obj->edad."</p>";
                            echo "</div>";
                            echo "<div id='descripcion'>";
                                echo "<p>".$obj->descripcion."</p>";
                            echo "</div>";
                            echo "<div id='precio'>";
                                echo "<p><h1>".$obj->precio." €</h1>";
                            echo "</div>";
                        echo "</div>";
                    $alquiler = "SELECT * FROM alquiler WHERE idalquiler = {$_GET['id']};";
                }else
                    echo "Imposible conseguir los datos";
        }else
            echo "Query Failed";

        if(isset($_POST['alquiler'])){
            $alquilerCorrecto = true;

            $alquilerID = 0;
            $animalID = $_GET['id'];

            // 1. Insertar en tabla Alquiler
            $fecha = date('Y-m-d');
            $insertar = "INSERT INTO alquiler
                         VALUES (NULL, {$_SESSION['iduser']}, '$fecha');
                        ";
            if ($result = $connection->query($insertar)) {
                if ($result){
                    $alquilerID = $connection->insert_id;
                }else{
                    echo "Error al alquilar animal (insertar en tabla alquiler).";
                    $alquilerCorrecto = false;
                }
            }else{
                echo "Consulta errónea 1";
                $alquilerCorrecto = false;
            }

            // 2. Insertar en la tabla 'tiene'
            $meter = "INSERT INTO tiene VALUES($alquilerID, $animalID, 1);";
            if ($result = $connection->query($meter)) {
                if (!$result){
                    echo "Error al alquilar animal (insertar en tabla tiene).";
                    $alquilerCorrecto = false;
                }
            }else{
                echo "Consulta errónea 2";
                $alquilerCorrecto = false;
            }

            if($alquilerCorrecto){
                echo "<div id=ya>";
                echo "¡Gracias por alquilar en Animal Shop!. Podrá recoger y pagar este alquiler en nuestra tienda.";
                echo "</div>";
            }

        }

    ?>


    <input id="volver" type="button" onclick=" location.href='/php/proyecto/animales.php' " value="Volver" style=cursor:pointer; name="boton"
    />
    <form method="post">
        <input id="alquiler" type="submit" value="Alquilar" style="cursor:pointer;" name="alquiler" />
    </form>
</body>
</html>