<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
        $connection;

        //variable global donde guarda el resultado de la funcion
        function connecBD($host, $user, $password, $database){
            global $connection;

            // Report all errors except 'E_WARNING'
            // Install.php - When database connection is wrong, it showed this error always
            error_reporting(E_ALL ^ E_WARNING);

            $connection = new mysqli($host, $user, $password, $database);
            $connection->set_charset("utf8");

            if ($connection->connect_errno) {
                echo "Connection failed with database";
                // exit();
                return "false";
            }else
                return "true";
        }

        function changeTheme(){

            if(isset($_SESSION["temaUsuario"])){
                if($_SESSION["temaUsuario"] == "Rojo"){
                  echo "<script>
                      window.onload = function(){
                        var element = document.getElementById('color1');
                        if(element != undefined)
                          element.setAttribute('checked', 'checked');
                        document.getElementsByTagName('body')[0].style.background = '#c63a3a';
                      };
                      </script>";
                }
                else if($_SESSION["temaUsuario"] == "Negro"){
                  echo "<script>
                      window.onload = function(){
                        var element = document.getElementById('color2');
                        if(element != undefined)
                          element.setAttribute('checked', 'checked');

                        document.getElementsByTagName('body')[0].style.background = '#620909';
                      };
                      </script>";
                }else if($_SESSION["temaUsuario"] == "Rosa"){
                  echo "<script>
                      window.onload = function(){
                        var element = document.getElementById('color3');
                        if(element != undefined)
                          element.setAttribute('checked', 'checked');

                        document.getElementsByTagName('body')[0].style.background = '#e4e0ea';
                      };
                      </script>";
                }
            }else{
                // Si estoy en el login, se aplique por defecto el tema 'Rojo'
                echo "<script>
                      window.onload = function(){
                        var element = document.getElementById('color1');
                        if(element != undefined)
                          element.setAttribute('checked', 'checked');
                        document.getElementsByTagName('body')[0].style.background = '#c63a3a';
                      };
                      </script>";
            }
        }
 	?>
</body>
</html>