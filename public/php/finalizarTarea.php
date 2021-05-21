<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();




$query = "UPDATE `ALERTASANIMALES` SET `ESTADO`='FINALIZADA', `USUARIO`=" .$received_data->usuario ." WHERE ID = ".$received_data->query;

$consulta = mysql_query($query);



echo "Tarea finalizada";
?>