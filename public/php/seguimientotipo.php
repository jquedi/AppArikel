<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


if($received_data->query == "GUIA"){
	$query = "SELECT * FROM SEGUIMIENTOTIPO WHERE GUIAS = 'SI'";
}else{
	$query = "SELECT * FROM SEGUIMIENTOTIPO";
}


$consulta = mysql_query($query);

$resultado = array();

while($registro = mysql_fetch_array($consulta)){
	$resultado[]=$registro;
	
}

echo json_encode($resultado);

?>