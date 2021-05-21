<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();




$query = "UPDATE `EVENTOS` SET `ACTIVO` = 'NO', ESTADO = 'FINALIZADO' WHERE ID = ".$received_data->idEvento;

$consulta = mysql_query($query);



echo "OK";
?>