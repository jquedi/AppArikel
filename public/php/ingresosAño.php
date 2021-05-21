<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$tipo = $received_data->tipo;


$año = $received_data->año;


$datos = [];


for($i = 0; $i < 12; $i++){

    $j = $i + 1;

$fecha1 = $año ."-" .$j ."-1";
$fecha2 = $año ."-" .$j ."-31";

    $query = "SELECT SUM(LIQUIDO) AS TOTAL FROM `INGRESOS` WHERE (FECHA BETWEEN '" .$fecha1 ."' AND '" .$fecha2 ."') AND `TIPO` = " .$tipo ;

    $consulta = mysql_query($query);

    $resultado = "";

    while($registro = mysql_fetch_array($consulta)){
        $resultado=$registro["TOTAL"];
        
    }

    $datos[$i] = $resultado;

}











echo json_encode($datos);
?>