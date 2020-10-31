<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "SELECT * FROM ALERTAS WHERE IDPERSONA = '" .$received_data->usuario ."' AND ACTIVA = 'SI' ORDER BY HASTA";

$consulta = mysql_query($query);

$resultado = [];

while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro;
}

echo json_encode($resultado);
?>