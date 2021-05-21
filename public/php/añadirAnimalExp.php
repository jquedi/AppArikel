<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "INSERT INTO ANIMALESEXPEDIENTE (`ID`, `IDANIMAL`, `IDEXPEDIENTE`, `TIPO`, `ESTADO`, `NOTAS`, `CAMPO1`, `CAMPO2`, `CAMPO3`) VALUES ('', '" .$received_data->persona ."', '" .$received_data->exp ."' ,'" .$received_data->tipo ."', '" .$received_data->estado ."', '" .$received_data->notas ."', '', '', '')";

$consulta = mysql_query($query);


echo "Animal vinculado al expediente";
?>