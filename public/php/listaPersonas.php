<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


if($received_data->query != '')
{
	$query = "SELECT * FROM PERSONAS WHERE ID > 0 AND (NOMBRE LIKE '%".$received_data->query."%' OR APELLIDO1 LIKE '%".$received_data->query."%' OR APELLIDO2 LIKE '%".$received_data->query."%')";
}
else
{
	$query = "SELECT * FROM PERSONAS WHERE ID > 0";
}


$consulta = mysql_query($query);

$resultado = [];

while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro;
}

echo json_encode($resultado);
?>