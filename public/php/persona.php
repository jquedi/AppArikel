<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "SELECT NOMBRE FROM PERSONAS WHERE ID = ".$received_data->query;

$consulta = mysql_query($query);

$resultado = "";

while($registro = mysql_fetch_array($consulta)){
	$resultado=$registro["NOMBRE"];
	
}

$query1 = "SELECT APELLIDO1 FROM PERSONAS WHERE ID = ".$received_data->query;

$consulta1 = mysql_query($query1);

$resultado1 = "";

while($registro1 = mysql_fetch_array($consulta1)){
	$resultado1=$registro1["APELLIDO1"];
	
}

$query2 = "SELECT APELLIDO2 FROM PERSONAS WHERE ID = ".$received_data->query;

$consulta2 = mysql_query($query2);

$resultado2 = "";

while($registro2 = mysql_fetch_array($consulta2)){
	$resultado2=$registro2["APELLIDO2"];
	
}

echo  $resultado1 ." " .$resultado2 ." " .$resultado;

?>