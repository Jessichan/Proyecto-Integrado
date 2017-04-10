<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Instalacion</title>
    <link rel="stylesheet" href="css/install.css">
</head>
<body>

    <?php
        include_once "conec.php";

        session_start();

        if(file_exists("database.php"))
            header('Location: index.php');

        if (isset($_POST["botonInstalar"])) {

            $dbName          = $_POST['nombreBD'];
            $dbUser          = $_POST['usuarioBD'];
            $dbPass          = $_POST['claveBD'];
            $dbHost          = $_POST['hostBD'];
            $dbInsertarDatos = (isset($_POST['insertarDatos'])) ? "true" : "false";

            $connect = connecBD($dbHost, $dbUser, $dbPass, $dbName);
            if($connect == "true"){
                insertarTablaCliente($connection);
                insertarTablaAlquiler($connection);
                insertarTablaAnimal($connection);
                insertarTablaTiene($connection);
                insertarTablaAccesorio($connection);
                insertarTablaCompra($connection);

                if($dbInsertarDatos == "true"){
                    insertarvalorClientes($connection);
                    insertarvalorAlquiler($connection);
                    insertarvalorAnimal($connection);
                    insertarvalorTiene($connection);
                    insertarvalorAccesorio($connection);
                    insertarvalorCompra($connection);
                }

                // creamos un archivo con la conexion y las variables de la db
                $dataFile = "<?php\n\tconst DB_NAME = '$dbName';\n\tconst DB_USER = '$dbUser';\n\tconst DB_PASS = '$dbPass';\n\tconst DB_HOST = '$dbHost';\n?>";

                $file = fopen("database.php", "w");
                fwrite($file, $dataFile);
                Fclose($file);

                echo "<div id=completada>";
                echo "Instalacion completada";
                echo "</div>";
            }
        }
        if (isset($_POST["botonFinalizar"])) {
            if(file_exists("database.php"))
                header('Location: index.php');
            else
                echo "Necesitas completar la instalación";
        }

        function insertarTablaCliente($connection){
            $insertarTabla = "
                create table cliente
                (
                idcliente       int auto_increment not null,
                nombre          varchar(25),
                apellidos       varchar(50),
                telefono        varchar(9),
                email           varchar(100),
                usuario         varchar(15),
                tipo            varchar(20),
                password        varchar(50),
                primary key(idcliente)
                );
            ";

            if ($result = $connection->query($insertarTabla)) {
                if (!$result)
                    echo "Nos se han podido insertar datos en la tabla clientes";
            }else
                echo "Wrong Query";
        }

        function insertarTablaAlquiler($connection){
            $insertarTabla = "
            create table alquiler
            (
            idalquiler      int auto_increment not null,
            idcliente       int,
            fecha           date,
            primary key(idalquiler, idcliente),
            foreign key(idcliente) references cliente(idcliente) on delete cascade
            );
            ";

            if ($result = $connection->query($insertarTabla)) {
                if (!$result)
                    echo "No se han podido insertar datos en la tabla alquiler";
            }else
                echo "Wrong Query";
        }


        function insertarTablaAnimal($connection){
            $insertarTabla = "
            create table animal
            (
                idanimal        int auto_increment not null,
                especie         varchar(20),
                nombre          varchar(25),
                raza            varchar(50),
                edad            varchar(10),
                descripcion     varchar(500),
                precio          decimal(5,2),
                imagen          varchar(500),
                primary key(idanimal)
             );
            ";

            if ($result = $connection->query($insertarTabla)) {
                if (!$result)
                    echo "No se han podido insertar datos en la tabla animal";
            }else
                echo "Wrong Query";
        }

        function insertarTablaTiene($connection){
            $insertarTabla = "
            create table tiene
            (
                idalquiler      int,
                idanimal        int,
                cantidad        int,
                primary key(idalquiler, idanimal),
                foreign key(idalquiler) references alquiler(idalquiler) on delete cascade,
                foreign key(idanimal) references animal(idanimal) on delete cascade
            );
            ";

            if ($result = $connection->query($insertarTabla)) {
                if (!$result)
                    echo "No se han podido insertar datos en la tabla tiene";
            }else
                echo "Wrong Query";
        }

        function insertarTablaAccesorio($connection){
            $insertarTabla = "
            create table accesorio
            (
                idaccesorio     int auto_increment not null,
                nombre          varchar(50),
                descripcion     varchar(500),
                cantidad        int,
                precio          decimal(4,2),
                imagen          varchar(500),
                primary key(idaccesorio)
            );
            ";

            if ($result = $connection->query($insertarTabla)) {
                if (!$result)
                    echo "No se han podido insertar datos en la tabla accesorio";
            }else
                echo "Wrong Query";
        }

        function insertarTablaCompra($connection){
            $insertarTabla = "
            create table compra
            (
                idcliente       int,
                idaccesorio     int,
                cantidad        int,
                preciototal     decimal(4,2),
                primary key(idcliente, idaccesorio),
                foreign key(idcliente) references cliente(idcliente) on delete cascade,
                foreign key(idaccesorio) references accesorio(idaccesorio) on delete cascade
            );
            ";

            if ($result = $connection->query($insertarTabla)) {
                if (!$result)
                    echo "No se han podido insertar datos en la tabla compra";
            }else
                echo "Wrong Query";
        }



function insertarvalorClientes($connection){
    $insertarvalor = [];

    // Pass: 1234
    $insertarvalor[0] = "
      insert into cliente values(null, 'Maria', 'Gonzalez', '657890634','mariag@gmail.com','admin', 'Admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220');
    ";
    // 12345678
    $insertarvalor[1] = "
      insert into cliente values(null, 'Carlos', 'Martin', '654321672', 'carlosmar@gmail', 'carlos', 'User', '7c222fb2927d828af22f592134e8932480637c0d');
    ";
    // 123456
    $insertarvalor[2] = "
      insert into cliente values(null, 'Amanda', 'Marin', '647896541', 'amanda23@gmail.com', 'amanda', 'User', '7c4a8d09ca3762af61e59520943dc26494f8941b');
    ";
    // josel
    $insertarvalor[3] = "
      insert into cliente values(null, 'Jose', 'Laguillo', '654789064', 'josela@gmail.com', 'josel', 'User', 'e4d1decaf0dee5323423dceff9f3b0df1ff6c965');
    ";
    // jonim
    $insertarvalor[4] = "
      insert into cliente values(null, 'Jonni', 'Melavo', '654378906', 'joni@gmail.com', 'jonim', 'User', '9e8970052acaf49813b8209bf5478942ddd953b8');
    ";
    // holim
    $insertarvalor[5] = "
      insert into cliente values(null, 'Holi', 'Moli', '675432349', 'holimoli@hotmail.com', 'holim', 'User', '06df3c817ae65cde33d99f4023fd105a57062228');
    ";

    foreach($insertarvalor as $value){
        if ($result = $connection->query($value)){
              if (!$result)
                  echo "No se ha podido insertar valores en la tabla clientes";
        }else
            echo "Wrong Query";
    }
}

function insertarvalorAlquiler($connection){
    $insertarvalor = [];

    $insertarvalor[0] = "
      insert into alquiler values(null, 3, now());
    ";
    $insertarvalor[1] = "
      insert into alquiler values(null, 5, now());
    ";
    $insertarvalor[2] = "
      insert into alquiler values(null, 2, now());
    ";
    $insertarvalor[3] = "
      insert into alquiler values(null, 4, now());
    ";
    $insertarvalor[4] = "
      insert into alquiler values(null, 6, now());
    ";

    foreach($insertarvalor as $value){
        if ($result = $connection->query($value)){
              if (!$result)
                  echo "No se ha podido insertar valores en la tabla alquiler";
        }else
            echo "Wrong Query";
    }
}


function insertarvalorAnimal($connection){
    $insertarvalor = [];

    $insertarvalor[0] = "
      insert into animal values(null, 'Perro', 'Peludo', 'Golden Retriever', '3 meses', 'Este perrito es muy cariñoso y energetico. Le gusta estar acompañado y duerme mucho si se aburre. Necesita que se canse cuando sale a la calle haciendo ejercicio para mantenerse agil y joven.', 18.00, '/php/proyecto/img/peludo.png');
    ";
    $insertarvalor[1] = "
      insert into animal values(null, 'Gato', 'Garfield', 'Bengala', '4 meses', 'Este gatito que parece un tigre por sus rayas negras es muy mimoso y gloton, le gusta mucho la lasaña y es un poco flojo. Puede quedarse muchos horas en un mismo sitio sin moverse.', 20.00, '/php/proyecto/img/gato.jpg');
    ";
    $insertarvalor[2] = "
     insert into animal values(null, 'Pajaro', 'Manuel', 'Canario', '6 meses', 'Este canario es muy tranquilo le gusta que le pongan radiolé. Se baña en su pequeña bañera en verano.', 15.00, '/php/proyecto/img/canario.jpg');
    ";
    $insertarvalor[3] = "
     insert into animal values(null, 'Loro', 'Tina', 'Psittacus Erithacus', '2 meses', 'Este loro puede conversar contigo, puede insultarte, y puede cantarte canciones como el himno del sevilla.', 23.00, '/php/proyecto/img/loro.jpg');
    ";
    $insertarvalor[4] = "
     insert into animal values(null, 'Perro', 'Giva', 'Dalmata', '1 año',  'Esta dalmata es muy sobona y te hace ruido cuando esta tendida y vas a darle cariño. Necesita pasear y hacer ejercicio.', 17.00, '/php/proyecto/img/dalmata.jpg');
    ";
    $insertarvalor[5] = "
      insert into animal values(null, 'Conejo', 'Sabana', 'Belier Gold', 'año y medio', 'Este conejo le gusta comer de todo y correr por el cesped. No necesita muchos cuidados.', 14.00, '/php/proyecto/img/conejo.jpg');
    ";
    $insertarvalor[6] = "
      insert into animal values(null, 'Hamster', 'Currito', 'Hamster Comun', '1 año' , 'A este hamster le gusta dar vueltas en su rueda de la jaula, comer y dormir.', 12.50, '/php/proyecto/img/hanster.jpg');
    ";
    $insertarvalor[7] = "
       insert into animal values(null, 'gato', 'Doraemon', 'Bombai', '1 año', 'gato juegueton y cariñoso', 18.00, '/php/proyecto/img/doraemon.png');
    ";
    $insertarvalor[8] = "
       insert into animal values(null, 'Cobaya', 'Kitty', 'Peruana', '1 año', 'Kitty es un bicho muy gracioso y peludo. Le gusta la lechuga y que la saquen un poquito de su jaula. Puede cagarse encima tuya, ¡ten cuidao!', 15.00, '/php/proyecto/img/cobaya.jpg');
    ";
    $insertarvalor[9] = "
       insert into animal values(null, 'Perro', 'Jara', 'Meztiza', '9 años', 'chucha agil y pedidora de comida, siempre quiere estar acompanada, no le guusta estar sola.', 20.00, '/php/proyecto/img/jara.png');
    ";
    $insertarvalor[10] = "
       insert into animal values(null, 'Cotorras', 'Pepito Juanito', 'Cotorras Cubanas', '8 meses', 'estas cotorras pueden hablar y son muy graciosas.', 20.00, '/php/proyecto/img/cotorras.jpg');
    ";
    $insertarvalor[11] = "
       insert into animal values(null, 'Perro', 'Yaico', 'Husky Siberiano', '7 meses', 'Perro muy jugueton y sociable. Necesita pasear y hacer ejercicio.', 27.00, '/php/proyecto/img/yaico.jpg');
    ";
    $insertarvalor[12] = "
       insert into animal values(null, 'Perro', 'Rokko', 'Pastor Aleman', '1 año', 'Es muy jugueton y no le gusta estar solo. Todavia es pequeño y te hace algunas travesuras.', 25.00, '/php/proyecto/img/rokko.jpg');
    ";

    foreach($insertarvalor as $value){
        if ($result = $connection->query($value)){
              if (!$result)
                  echo "No se ha podido insertar valores en la tabla animal";
        }else
            echo "Wrong Query";
    }
}

function insertarvalorTiene($connection){
    $insertarvalor = [];

    $insertarvalor[0] = "
      insert into tiene values(4, 3, 1);
    ";
    $insertarvalor[1] = "
      insert into tiene values(2, 2, 1);
    ";
    $insertarvalor[2] = "
      insert into tiene values(2, 8, 1);
    ";
    $insertarvalor[3] = "
      insert into tiene values(3, 5, 1);
    ";
    $insertarvalor[4] = "
      insert into tiene values(5, 4, 1);
    ";
    $insertarvalor[5] = "
       insert into tiene values(1, 6, 1);
    ";
    foreach($insertarvalor as $value){
        if ($result = $connection->query($value)){
              if (!$result)
                  echo "No se ha podido insertar valores en la tabla tiene";
        }else
            echo "Wrong Query";
    }
}


function insertarvalorAccesorio($connection){
    $insertarvalor = [];

    $insertarvalor[0] = "
      insert into accesorio values(null, 'Correa','Correa para perros' , 10, 3.00, '/php/proyecto/img/correa.jpg');
    ";
    $insertarvalor[1] = "
      insert into accesorio values(null, 'Sonajero', 'Juguete para gatos o perros', 10, 2.50, '/php/proyecto/img/sonajero.jpg');
    ";
    $insertarvalor[2] = "
     insert into accesorio values(null, 'Hueso Comestible', 'hueso sabroso para perros', 20, 4.00, '/php/proyecto/img/hueso.jpg');
    ";
    $insertarvalor[3] = "
     insert into accesorio values(null, 'Brekkies Excel Junior', 'Comida para perros pequeños', 10, 7.00, '/php/proyecto/img/comida1.jpg');
    ";
    $insertarvalor[4] = "
     insert into accesorio values(null, 'Brekiies Excel Senior', 'Comida para perros de mas de 7 años', 10, 7.50, '/php/proyecto/img/comida2.jpg');
    ";
    $insertarvalor[5] = "
      insert into accesorio values(null, 'Brekkies Excel Cat', 'Comida sabrosa para gatos', 10, 8.00, '/php/proyecto/img/comidag.jpg');
    ";
    $insertarvalor[6] = "
      insert into accesorio values(null, 'vitakraft menu', 'Comida para pequeños roedores', 10, 8.00, '/php/proyecto/img/comidac.jpg');
    ";
    $insertarvalor[7] = "
       insert into accesorio values(null, 'Pio pa', 'Mezcla para canarios', 10, 1.77, '/php/proyecto/img/mezclac.jpg');
    ";
    $insertarvalor[8] = "
       insert into accesorio values(null, 'Jaula Conejo', 'Jaula mediana para conejos', 10, 8.00, '/php/proyecto/img/jaulaconejo.jpg');
    ";
    $insertarvalor[9] = "
       insert into accesorio values(null, 'Jaula Hanster', 'Jaula pequeña para hansters', 10, 7.50, '/php/proyecto/img/jaulahanster.jpg');
    ";
    $insertarvalor[10] = "
       insert into accesorio values(null, 'Jaula Loros', 'Jaula mediana para loros', 10, 8.00, '/php/proyecto/img/jaulaloros.jpg');
    ";
    $insertarvalor[11] = "
       insert into accesorio values(null, 'Cama', 'Cama en forma de casa para perros o gatos', 10, 7.00, '/php/proyecto/img/camapega.jpg');
    ";
    $insertarvalor[12] = "
       insert into accesorio values(null, 'Cama Sofa', 'Cama para perros muy comoda', 8, 10.00, '/php/proyecto/img/camasofa.jpg');
    ";
    $insertarvalor[13] = "
       insert into accesorio values(null, 'Jaula Pajaros', 'Jaula mediana para uno o dos pajaros', 7, 7.00, '/php/proyecto/img/jaulapajaros.jpg');
    ";
    $insertarvalor[14] = "
       insert into accesorio values(null, 'Ropa Perros Pequeños', 'Ropa para perros pequeños. Tallas S, M, L, XL', 10, 12.00, '/php/proyecto/img/ropagris.jpg');
    ";
    $insertarvalor[15] = "
       insert into accesorio values(null, 'Ropa Perros Grandes', 'Ropa para perros grandes. Tallas S, M, L, XL', 10, 16.00, '/php/proyecto/img/ropagrande.jpg');
    ";
    foreach($insertarvalor as $value){
        if ($result = $connection->query($value)){
              if (!$result)
                  echo "No se ha podido insertar valores en la tabla accesorio";
        }else
            echo "Wrong Query";
    }
}


function insertarvalorCompra($connection){
    $insertarvalor = [];

    $insertarvalor[0] = "
      insert into compra values(3, 7, 1, 8.00);
    ";
    $insertarvalor[1] = "
      insert into compra values(2, 4, 1, 7.00);
    ";
    $insertarvalor[2] = "
      insert into compra values(4, 8, 1, 1.77);
    ";
    $insertarvalor[3] = "
      insert into compra values(5, 2, 1, 2.50);
    ";
    $insertarvalor[4] = "
      insert into compra values(6, 2, 1, 2.50);
    ";
    foreach($insertarvalor as $value){
        if ($result = $connection->query($value)){
              if (!$result)
                  echo "No se ha podido insertar valores en la tabla compra";
        }else
            echo "Wrong Query";
    }
}
    ?>



    <p><center>Bienvenido a la instalacion, es rapida y sencilla.</center></p>

    <p><center>Rellene los siguientes campos</center></p>

    <div id="caja">
        <img id="logo" src="img/logo.png">
        <form class='instalar' method="post">
            <div>
                <label>Nombre Database</label>
                <input name="nombreBD" type="text" value="animalshop" required>
            </div>
            <div>
                <label>Usuario</label>
                <input name="usuarioBD" type="text" value="mascota" required>
            </div>
            <div>
                <label>Clave</label>
                <input name="claveBD" type="text" value="minino" required>
            </div>
            <div>
                <label>Host</label>
                <input name="hostBD" type="text" value="localhost" required>
            </div>
            <div>
            <label>Insertar datos
                <input type="checkbox" name="insertarDatos" checked>
            </label>

            </div>
            <div>
                <input type="submit" value="Instalar" name="botonInstalar" style=cursor:pointer;>
            </div>
            <div id="fin">
                <input type="submit" value="Finalizar" name="botonFinalizar" style=cursor:pointer;>
            </div>
        </form>
    </div>
</body>
</html>