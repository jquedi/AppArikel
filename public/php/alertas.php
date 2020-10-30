<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


$query = "SELECT NOMBRE FROM PERSONAS WHERE ID = " .$received_data->usuario;

$consulta = mysql_query($query);

$nombre = "";

while($registro = mysql_fetch_array($consulta)){
	$nombre=$registro["NOMBRE"];
	
}



$query = "SELECT * FROM ALERTAS WHERE USUARIO = '" .$nombre ."' AND ACTIVA = 'SI' ORDER BY HASTA";

$consulta = mysql_query($query);

$resultado = [];

while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro;
}

echo json_encode($resultado);
?>