<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "DELETE FROM ANIMALESEXPEDIENTE WHERE IDANIMAL = " .$received_data->animal ." AND IDEXPEDIENTE = " .$received_data->exp;

$consulta = mysql_query($query);


echo "Animal desvinculado de expediente";
?>