<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "UPDATE ALERTAS SET ACTIVA = 'NO' WHERE ID = " .$received_data->idAlerta;

$consulta = mysql_query($query);


echo "Alerta Eliminada";
?>