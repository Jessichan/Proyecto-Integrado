<!DOCTYPE html>
<html>
<head>
    <title>Ajustes</title>
    <link rel="stylesheet" href="css/ajustes.css">
    <script src="js/chart_google.js"></script>
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

            }else
                header('Location: /php/proyecto/login.php');

        //temas
        if(isset($_POST["theme"])){
            if($_POST['cambiarcolor'] == "Rosa")        $_SESSION["temaUsuario"] = "Rosa";
            else if($_POST['cambiarcolor'] == "Violeta")  $_SESSION["temaUsuario"] = "Violeta";
            else if($_POST['cambiarcolor'] == "Morado")     $_SESSION["temaUsuario"] = "Morado";
        }
        changeTheme();
    ?>
    <div id="caja">
        <h2>Colores</h2>
        <form method='post'>
            <label>
                <input id="color4" type="radio" name="cambiarcolor" value="Rosa">Rosa
            </label>
            <label>
                <input id="color5" type="radio" name="cambiarcolor" value="Violeta">Violeta
            </label>
            <label>
                <input id="color6" type="radio" name="cambiarcolor" value="Morado">Morado
            </label>
            <input id="cambiar" type='submit' name="theme" value="Cambiar">
        </form>
        <input id="volver" type="submit" onclick=" location.href='/php/proyecto/administracion.php' " value="Volver" style=cursor:pointer; />
        <h2>Actividad De Usuario</h2>
        <div id="piechart"></div><br>
        <?php
            //grafica
            // usuarios y productos
            $totaldeusuarios = 0;
            $totaldeanimales = 0;
            $totaldeaccesorios = 0;

            // Nº total de usuarios
            $numusuarios = "SELECT *
                              FROM cliente";

            if ($result = $connection->query($numusuarios)) {
                if ($result->num_rows > 0)
                    $totaldeusuarios = $result->num_rows;
                else
                    echo "No hay usuarios registrados";
            }else
                echo "Query fallida";

            // Nº total de animales
            $numanimales = "SELECT *
                              FROM animal";

            if ($result = $connection->query($numanimales)) {
                if ($result->num_rows > 0)
                    $totaldeanimales = $result->num_rows;
                else
                    echo "No hay animales registrados";
            }else
                echo "Query fallida";

            // Nº total de accesorios
            $numaccesorios = "SELECT *
                              FROM accesorio";

            if ($result = $connection->query($numaccesorios)) {
                if ($result->num_rows > 0)
                    $totaldeaccesorios = $result->num_rows;
                else
                    echo "No hay animales registrados";
            }else
                echo "Query fallida";
        ?>


        <script>
            // variables grafica
            var totaldeusuarios = <?php echo json_encode($totaldeusuarios); ?>;
            var totaldeanimales = <?php echo json_encode($totaldeanimales); ?>;
            var totaldeaccesorios = <?php echo json_encode($totaldeaccesorios); ?>;

            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                if(totaldeusuarios == 0 && totaldeanimales == 0 && totaldeaccesorios == 0){
                    var data = google.visualization.arrayToDataTable([
                        ['Task', 'Hours per Day'],
                        ['No data', 1]
                        ]);
                }else{
                    var data = google.visualization.arrayToDataTable([
                        ['Task', 'Hours per Day'],
                        ['Cantidad total de usuarios', totaldeusuarios],
                        ['Cantidad total de animales', totaldeanimales],
                        ['Cantidad total de accesorios', totaldeaccesorios]
                        ]);
                }
                var options = {
                // title: 'Amounts of user'
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        </script>
    </div>
</body>
</html>