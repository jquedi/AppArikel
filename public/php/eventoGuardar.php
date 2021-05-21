<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


if($received_data->idEvento != ''){
    $query = "UPDATE EVENTOS SET DESCRIPCION = '".$received_data->descripcion ."', LOCALIZACION = '".$received_data->localizacion ."', INICIO = '".$received_data->fecha1 ."', FINAL = '".$received_data->fecha2 ."', TIPO = '".$received_data->tipo ."', ESTADO = '".$received_data->estado ."', NOTAS = '".$received_data->notas ."', CAMPO1 = '".$received_data->campo1 ."', ACTIVO = '".$received_data->activo ."' WHERE ID = " .$received_data->idEvento;

    $consulta = mysql_query($query);
}else{
    $query = "INSERT INTO EVENTOS (`DESCRIPCION`, `LOCALIZACION`, `INICIO`, `FINAL`, `TIPO`, `ESTADO`, `NOTAS`, `CAMPO1`, `ACTIVO`) VALUES ('".$received_data->descripcion ."','".$received_data->localizacion ."','".$received_data->fecha1 ."','".$received_data->fecha2 ."','".$received_data->tipo ."','".$received_data->estado ."','".$received_data->notas ."','".$received_data->campo1 ."','".$received_data->activo ."')";

    $consulta = mysql_query($query);
}



echo "OK";

?>