<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


$query = "INSERT INTO ALERTASANIMALES (ID, ANIMAL, DESCRIPCION, TIPO, FECHAINICIO, FECHALIMITE, RECURSIVIDAD, RECURSIVIDADTIPO, FIJO, USUARIO, ESTADO) VALUES ('','" .$received_data->animal ."','" .$received_data->descripcion ."','" .$received_data->tipo ."','" .$received_data->fecha1 ."','" .$received_data->fecha2 ."','" .$received_data->recursividad ."','" .$received_data->recursividadTipo ."','NO',0,'ACTIVO')";

$consulta = mysql_query($query);


echo $query;
?>