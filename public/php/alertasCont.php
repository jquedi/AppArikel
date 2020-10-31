<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "SELECT COUNT(ID) AS contador FROM ALERTAS WHERE IDPERSONA = '" .$received_data->usuario ."' AND ACTIVA = 'SI'";

$consulta = mysql_query($query);

$resultado = "";

while($registro = mysql_fetch_array($consulta)){
    $resultado=$registro["contador"];
}

echo $resultado;
?>