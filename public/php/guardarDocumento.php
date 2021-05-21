<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


    $query = "INSERT INTO DOCUMENTO (`DOCUMENTO`, `DOCUMENTOSTIPO`, `NOTAS`, `RUTA`, `TIPO`, `EXPEDIENTE`, `CAMPO1`, `IDANIMAL`, `IDPERSONA`, `IDEVENTO`) VALUES ('".$received_data->documento ."','".$received_data->documentostipo ."','".$received_data->notas ."','".$received_data->ruta ."','".$received_data->tipo ."','".$received_data->expediente ."','".$received_data->campo1 ."','".$received_data->animal ."','".$received_data->persona ."','".$received_data->evento ."')";

    $consulta = mysql_query($query);




echo "Guardado";

?>