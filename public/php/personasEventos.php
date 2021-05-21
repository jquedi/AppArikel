<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();
$resultado = [];
$resultado3 = [];



$query3 = "SELECT IDPERSONA FROM PERSONASEVENTO WHERE ESTADO = '".$received_data->estado ."' AND IDEVENTO = " .$received_data->idEvento;

$consulta3 = mysql_query($query3);

while($registro3 = mysql_fetch_array($consulta3)){
    $resultado3[]=$registro3["IDPERSONA"];

    $query2 = "SELECT * FROM PERSONAS WHERE ID = " .$registro3["IDPERSONA"];

    $consulta2 = mysql_query($query2);
    
    while($registro2 = mysql_fetch_array($consulta2)){
        $resultado[]=$registro2;
    }
}


echo json_encode($resultado);
?>