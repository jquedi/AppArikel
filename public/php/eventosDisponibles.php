<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "SELECT * FROM EVENTOS WHERE ESTADO = 'ABIERTA INSCRIPCIÓN' AND ID NOT IN (SELECT IDEVENTO FROM PERSONASEVENTO WHERE IDPERSONA = " .$received_data->usuario .") ORDER BY INICIO DESC";

$consulta = mysql_query($query);

$resultado = array();

while($registro = mysql_fetch_array($consulta)){
	$resultado[]=$registro;
	
}

echo json_encode($resultado);
?>