<?php
include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$filtro = "";


if($received_data->tipo != ""){
	$filtro = $filtro ." AND TIPO = " .$received_data->tipo;
}
if($received_data->revisado != ""){
	$filtro = $filtro ." AND REVISADO = '" .$received_data->revisado ."'";
}


if($received_data->tipoG != ""){
	$filtro = $filtro ." AND TIPO_GASTO LIKE '%" .$received_data->tipoG ."%'";
}

if($received_data->cliente != ""){
	$filtro = $filtro ." AND CLIENTE LIKE '%" .$received_data->cliente ."%'";
}

if($received_data->pagado != ""){
	$filtro = $filtro ." AND PAGADO = '" .$received_data->pagado ."'";
}

if($received_data->fecha != "" && $received_data->fecha2 != ""){
	$filtro = $filtro ." AND (FECHA BETWEEN '" .$received_data->fecha ."' AND '" .$received_data->fecha2 ."')";
}




	$query = "SELECT * FROM INGRESOS WHERE ID > 0" .$filtro ." ORDER BY FECHA DESC";



$consulta = mysql_query($query);

$resultado = array();

while($registro = mysql_fetch_array($consulta)){
	$resultado[]=$registro;
	
}

echo json_encode($resultado);

?>