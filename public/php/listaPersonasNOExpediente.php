<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();
$resultado = [];
$resultado3 = [];




if($received_data->query != '')
{
    $query3 = "SELECT * FROM `PERSONAS` WHERE ID NOT IN (SELECT `IDPERSONA` FROM `PERSONASEXPEDIENTE` WHERE `IDEXPEDIENTE` = " .$received_data->exp .") AND (NOMBRE LIKE '%".$received_data->query."%' OR APELLIDO1 LIKE '%".$received_data->query."%' OR APELLIDO2 LIKE '%".$received_data->query."%')";
}
else
{
    $query3 = "SELECT * FROM `PERSONAS` WHERE ID NOT IN (SELECT `IDPERSONA` FROM `PERSONASEXPEDIENTE` WHERE `IDEXPEDIENTE` = " .$received_data->exp .")";
}

$consulta3 = mysql_query($query3);

    
while($registro2 = mysql_fetch_array($consulta3)){
    $resultado[]=$registro2;
}


echo json_encode($resultado);
?>