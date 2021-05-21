<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "SELECT IDEVENTO FROM PERSONASEVENTO WHERE IDPERSONA = ".$received_data->usuario ." AND ESTADO = 'ADMITIDO'";

$consulta = mysql_query($query);

$resultado = array();

while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro["IDEVENTO"];
    
    $query2 = "SELECT * FROM EVENTOS WHERE ID = '".$registro["IDEVENTO"] ."' AND ACTIVO = 'SI' AND ESTADO = 'ABIERTA INSCRIPCIÓN' ORDER BY INICIO DESC";
    $consulta2 = mysql_query($query2);

    while($registro2 = mysql_fetch_array($consulta2)){
        $resultado2[]=$registro2;
    }
	
}

echo json_encode($resultado2);

?>