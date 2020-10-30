<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();
$filtro = "";

if($received_data->animal != ""){
	$filtro = $filtro ." OR IDANIMAL = " .$received_data->animal;
}
if($received_data->evento != ""){
	$filtro = $filtro ." OR IDEVENTO = " .$received_data->evento;
}
if($received_data->expediente != ""){
	$filtro = $filtro ." OR EXPEDIENTE = " .$received_data->expediente;
}

$query1 = "SELECT * FROM DOCUMENTO WHERE TIPO = 2 OR TIPO = 4 IDPERSONA = ".$received_data->usuario ." AND ESTADO = 'ACTIVO'";

$consulta1 = mysql_query($query1);

$resultado1 = "";

while($registro1 = mysql_fetch_array($consulta1)){
	$resultado1=$registro1["IDEXPEDIENTE"];
	
}

$query = "SELECT IDANIMAL FROM ANIMALESEXPEDIENTE WHERE IDEXPEDIENTE = '".$resultado1 ."' AND ESTADO = 'TRABAJANDO'";

$consulta = mysql_query($query);

$resultado = array();

while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro["IDANIMAL"];
    
    $query2 = "SELECT * FROM ANIMALES WHERE ID = ".$registro['IDANIMAL'];
    $consulta2 = mysql_query($query2);

    while($registro2 = mysql_fetch_array($consulta2)){
        $resultado2[]=$registro2;
    }
	
}

echo json_encode($resultado2);

?>