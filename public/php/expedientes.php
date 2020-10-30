<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "SELECT IDEXPEDIENTE FROM PERSONASEXPEDIENTE WHERE IDPERSONA = '".$received_data->query ."' AND ESTADO = 'ACTIVO'";

$consulta = mysql_query($query);

$resultado = array();

while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro["IDEXPEDIENTE"];
    
    $query2 = "SELECT * FROM EXPEDIENTES WHERE ID = ".$registro['IDEXPEDIENTE'];
    $consulta2 = mysql_query($query2);

    while($registro2 = mysql_fetch_array($consulta2)){
        $resultado2[]=$registro2;
    }
	
}

echo json_encode($resultado2);

?>