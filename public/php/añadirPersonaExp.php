<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "INSERT INTO PERSONASEXPEDIENTE (`ID`, `IDPERSONA`, `IDEXPEDIENTE`, `TIPO`, `ESTADO`, `NOTAS`, `CAMPO1`, `CAMPO2`, `CAMPO3`) VALUES ('', '" .$received_data->persona ."', '" .$received_data->exp ."' ,'" .$received_data->tipo ."', 'ACTIVO', '" .$received_data->notas ."', '', '', '')";

$consulta = mysql_query($query);


echo "Persona vinculada al expediente";
?>