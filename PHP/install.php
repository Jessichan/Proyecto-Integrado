<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Instalacion</title>
    <link rel="stylesheet" href="css/install.css">
</head>
<body>

    <p><center>Bienvenido a la instalacion, es rapida y sencilla.</center></p>

    <p><center>Rellene los siguientes campos</center></p>

    <div id="caja">
        <img id="logo" src="img/logo.png">
        <form class='instalar' method="post">
            <div>
                <label>Nombre Database</label>
                <input name="user" type="text" value="animalshop" required>
            </div>
            <div>
                <label>Usuario</label>
                <input name="user" type="text" value="mascota" required>
            </div>
            <div>
                <label>Clave</label>
                <input name="clave" type="text" value="minino" required>
            </div>
            <div>
                <label>Host</label>
                <input name="host" type="text" value="localhost" required>
            </div>
            <div>
                <input type="submit" value="Instalar" style=cursor:pointer;>
            </div>
            <div id="fin">
                <input type="submit" value="Finalizar" style=cursor:pointer;>
            </div>
        </form>
    </div>
</body>
</html>