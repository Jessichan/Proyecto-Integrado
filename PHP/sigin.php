<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sigin</title>
    <link rel="stylesheet" href="css/sigin.css">
</head>
<body>
    <?php
        include_once "conec.php";

        session_start();

        changeTheme();

        file_exists("database.php") ? include_once "database.php" : header('Location: index.php');

        connecBD(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //Guarda info en variables
        if (isset($_POST["nombre"])) {
            $nom   = $_POST['nombre'];
            $ape   = $_POST['ape'];
            $tele  = $_POST['tfono'];
            $email = $_POST['email'];
            $user   = $_POST['user'];
            $tipo  = 'User';
            $pass   = sha1 ($_POST['pass']);

            $sigin = "INSERT INTO cliente VALUES (NULL, '$nom', '$ape', '$tele', '$email', '$user', '$tipo', '$pass');";

            if ($result = $connection->query($sigin)) {
                header("location: /php/proyecto/login.php");
            } else
                echo "Query fallida";
        }
    ?>

    <div id="caja">
        <img id="logo" src="/php/proyecto/img/logo.png">
        <form method="post">
            <div>
                <label>Nombre</label>
                <input name="nombre" type="text" maxlength="25" required>
            </div>
            <div>
                <label>Apellidos</label>
                <input name="ape" type="text" maxlength="50" required>
            </div>
            <div>
                <label>Telefono</label>
                <input name="tfono" type="tel" pattern="[0-9]{9}" required>
            </div>
            <div>
                <label>Email</label>
                <input name="email" type="email" maxlength="100" required>
            </div>
            <div>
                <label>Usuario</label>
                <input name="user" type="text" maxlength="15" required>
            </div>
            <div>
                <label>Password</label>
                <input name="pass" type="password" maxlength="50" required>
            </div>
            <input type="submit" value="Registrarse" style=cursor:pointer;>
            <input id="volver" type="button" onclick=" location.href='/php/proyecto/login.php' " value="Volver" style=cursor:pointer; name="boton" />
        </form>
    </div>
</body>
</html>