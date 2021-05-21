<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$tipo1 = $received_data->tipo;

$largo = count($tipo1);

$tipo2 = $received_data->tipo2;
$mes = $received_data->mes;
$año = $received_data->año;

$fecha1 = $año ."-" .$mes ."-1";
$fecha2 = $año ."-" .$mes ."-31";

$datos = [];


for($i = 0; $i < $largo; $i++){

    $query = "SELECT SUM(LIQUIDO) AS TOTAL FROM `INGRESOS` WHERE (FECHA BETWEEN '" .$fecha1 ."' AND '" .$fecha2 ."') AND `TIPO_GASTO` = '" .$tipo1[$i] ."' AND `TIPO` = " .$tipo2 ;

    $consulta = mysql_query($query);

    $resultado = "";

    while($registro = mysql_fetch_array($consulta)){
        $resultado=$registro["TOTAL"];
        
    }

    $datos[$i] = $resultado;

}











echo json_encode($datos);
?>