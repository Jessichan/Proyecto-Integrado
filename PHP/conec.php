<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
        $connection;

		// //CREATING THE CONNECTION
  //       // $connection = new mysqli("localhost", "mascota", "minino", "animalshop");
  //       $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  //       $connection->set_charset("utf8");
  //       //TESTING IF THE CONNECTION WAS RIGHT
  //       if ($connection->connect_errno) {
  //       	printf("Connection failed: %s\n", $connection->connect_error);
  //        	exit();
  //       }

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


 	?>
</body>
</html>