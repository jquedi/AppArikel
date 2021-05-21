<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "DELETE FROM PERSONASEXPEDIENTE WHERE IDPERSONA = " .$received_data->persona ." AND IDEXPEDIENTE = " .$received_data->exp;

$consulta = mysql_query($query);


echo "Persona desvinculada de expediente";
?>