<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();




$query = "UPDATE `ALERTASANIMALES` SET `RECURSIVIDAD`= 0 WHERE ID = ".$received_data->query;

$consulta = mysql_query($query);



echo "Repeticion cancelada";
?>