<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

	$query = "SELECT COUNT(*) AS CONTADOR FROM INGRESOS WHERE FECHA LIKE '" .$received_data->año ."%'";

$consulta = mysql_query($query);

$resultado = "";

while($registro = mysql_fetch_array($consulta)){
	$resultado=$registro["CONTADOR"];
	
}

$resultado = $resultado + 1;

echo $resultado ."/" .$received_data->año;

?>