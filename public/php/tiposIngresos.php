<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "SELECT DISTINCT(`TIPO_GASTO`) FROM `INGRESOS`";

$consulta = mysql_query($query);

$resultado = [];

while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro[0];
}

echo json_encode($resultado);
?>