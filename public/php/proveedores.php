<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();



if($received_data->query2 != '')
{
    $busca = " WHERE (NIF LIKE '%".$received_data->query2."%' OR CLIENTE LIKE '%".$received_data->query2."%' OR EMAIL LIKE '%".$received_data->query2."%')";
}
else
{
    $busca = "";
}


$query = "SELECT * FROM PROVEEDORES" .$busca;

$consulta = mysql_query($query);

$resultado = [];

while($registro = mysql_fetch_array($consulta)){
	$resultado[]=$registro;
	
}

echo json_encode($resultado);

?>