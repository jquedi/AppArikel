<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

	$query = "SELECT COUNT(*) AS CONTADOR FROM SEGUIMIENTOS WHERE ESTADO = 'REQUERIDO' AND IDPERSONA = " .$received_data->query ;

$consulta = mysql_query($query);

$resultado = "";

while($registro = mysql_fetch_array($consulta)){
	$resultado=$registro["CONTADOR"];
	
}

echo $resultado;

?>