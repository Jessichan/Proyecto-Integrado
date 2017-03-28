<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		//CREATING THE CONNECTION
        $connection = new mysqli("localhost", "mascota", "minino", "animalshop");
        $connection->set_charset("utf8");
        //TESTING IF THE CONNECTION WAS RIGHT
        if ($connection->connect_errno) {
        	printf("Connection failed: %s\n", $connection->connect_error);
         	exit();
        }
 	?>
</body>
</html>