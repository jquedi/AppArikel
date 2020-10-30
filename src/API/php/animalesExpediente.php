<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query1 = "SELECT ID FROM EXPEDIENTES WHERE DESCRIPCION = '".$received_data->query ."'";

$consulta1 = mysql_query($query1);

$resultado1 = "";

while($registro1 = mysql_fetch_array($consulta1)){
	$resultado1=$registro1["ID"];
	
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