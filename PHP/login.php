<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

    <?php
        include_once "conec.php";
        file_exists("database.php") ? include_once "database.php" : header('Location: index.php');

        connecBD(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //Si el usuario esta logueado
        session_start();

        //admin vaya a admin y user a menu
        if(isset($_SESSION['iduser'])){
            if($_SESSION['tipouser'] == "Admin")
                header('Location: administracion.php');
            else if($_SESSION['tipouser'] == "User")
                header('Location: menu.php');
        }

        //guardar sesion del usuario
        if (isset($_POST["user"])) {
            $user = $_POST['user'];
            $pass = sha1($_POST['pass']);

            $login = "SELECT idcliente, tipo
                      FROM cliente
                      WHERE usuario = ? AND
                            password = ?;
                     ";

            //sql inyection
            if ($query = $connection->prepare($login)) {

                $query->bind_param("ss", $user, $pass);
                $query->execute();
                $query->bind_result($userID, $userTipo);
                $query->fetch();

                if(isset($userID)){
                    $_SESSION['iduser'] = $userID;
                    $_SESSION['tipouser'] = $userTipo;

                    if ($userTipo == "Admin")
                        header('Location: administracion.php');
                    else if($userTipo == "User")
                        header('Location: menu.php');
                }else{
                    echo "Login incorrecto";
                }
                $query->close();
            }
        }
    ?>

    <div id="caja">
        <img id="logo" src="img/logo.png">
        <form class='login' method="post">
            <div>
                <label>Username</label>
                <input name="user" type="text" required>
            </div>
            <div>
                <label>Password</label>
                <input name="pass" type="password" required>
            </div>
            <div><center>
                <input type="submit" value="Entrar" style=cursor:pointer;></center>
            </div><center>
            <div>¿No tienes cuenta? <a href="sigin.php">Registrarse</a></div></center>
        </form>
    </div>
</body>
</html>