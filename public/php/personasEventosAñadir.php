<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();




$query = "UPDATE `PERSONASEVENTO` SET `ESTADO`='".$received_data->estado ."' WHERE IDPERSONA = ".$received_data->idPersona ." AND IDEVENTO = ".$received_data->idEvento;

$consulta = mysql_query($query);



echo "OK";
?>