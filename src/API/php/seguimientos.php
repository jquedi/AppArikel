<?php

//action.php

/*$connect = new PDO("mysql:host=rdbms.strato.de; dbname=DB4245417", "U4245417", "George21444267");*/

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$filtro = "";

if($received_data->tipo != ""){
	$filtro = $filtro ." AND TIPO = '" .$received_data->tipo ."'";
}
if($received_data->fecha != ""){
	$filtro = $filtro ." AND FECHA = '" .$received_data->fecha ."'";
}
if($received_data->expediente != ""){
	$query = "SELECT ID FROM EXPEDIENTES WHERE DESCRIPCION = '".$received_data->expediente ."'";

	$consulta = mysql_query($query);

	$expediente = "";

	while($registro = mysql_fetch_array($consulta)){
		$expediente=$registro["ID"];
	}

	$filtro = $filtro ." AND IDEXPEDIENTE = " .$expediente;
}


if($received_data->animal != ""){
	$query = "SELECT ID FROM ANIMALES WHERE NOMBRE = '".$received_data->animal ."'";

	$consulta = mysql_query($query);

	$animal = "";

	while($registro = mysql_fetch_array($consulta)){
		$animal=$registro["ID"];
	}

	$filtro = $filtro ." AND IDANIMAL = " .$animal;
}




if($received_data->query != '')
{
	$query = "SELECT * FROM SEGUIMIENTOS WHERE IDPERSONA = '".$received_data->usuario ."' AND (SUCESO LIKE '%".$received_data->query."%' OR REQUERIMIENTO LIKE '%".$received_data->query."%' OR FECHA LIKE '%".$received_data->query."%') ORDER BY FECHA DESC";
}
else
{
	$query = "SELECT * FROM SEGUIMIENTOS WHERE IDPERSONA = '".$received_data->usuario ."'" .$filtro ." ORDER BY FECHA DESC";
}


$consulta = mysql_query($query);

$resultado = array();

while($registro = mysql_fetch_array($consulta)){
	$resultado[]=$registro;
	
}

echo json_encode($resultado);

?>