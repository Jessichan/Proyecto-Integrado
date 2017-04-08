<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
    <?php
        include_once "conec.php";

        file_exists("database.php") ? include_once "database.php" : header('Location: index.php');

        connecBD(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        session_start();

        include_once "usuario.php";
    ?>


    <img id="enca" src="/php/proyecto/img/porta.jpg">
    <div id="caja">
        <form method="post" id="Desconectar">
            <input type="submit" name="desloguear" value="Desconectar" style=cursor:pointer;>
        </form>
        <?php echo "<p id=\"saludo\"> Hola, $nombreusuario</p>" ?>
        <br>
        <input id="ani" type="button" onclick=" location.href='/php/proyecto/animales.php' " value="Animales" style=cursor:pointer; name="boton2" />
        <input  id="ac" type="button" onclick=" location.href='/php/proyecto/accesorios.php' " value="Accesorios" style=cursor:pointer; name="boton1" />
    </div>
</body>
</html>