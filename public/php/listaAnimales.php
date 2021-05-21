<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


if($received_data->query != '')
{
	$query = "SELECT * FROM ANIMALES WHERE ID > 0 AND NOMBRE LIKE '%".$received_data->query."%' ORDER BY ALERTAS DESC";
}
else
{
	$query = "SELECT * FROM ANIMALES WHERE ID > 0 ORDER BY ALERTAS DESC";
}


$consulta = mysql_query($query);

$resultado = [];

while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro;
}

echo json_encode($resultado);
?>