<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$opcion = $received_data->opcion;
$cat = $received_data->permiso;
$id = $received_data->id;


if($cat != "EDITAR"){
    $filtro = " AND (IDPERSONA = 0 OR IDPERSONA = " .$id .") AND (EXPEDIENTE IN (SELECT IDEXPEDIENTE FROM `PERSONASEXPEDIENTE` WHERE `IDPERSONA` = " .$id ." AND ESTADO = 'ACTIVO') OR EXPEDIENTE = 0) AND (IDEVENTO = 0 OR IDEVENTO IN (SELECT IDEVENTO FROM `PERSONASEVENTO` WHERE `IDPERSONA` = " .$id ." AND ESTADO = 'ADMITIDO')) AND (IDANIMAL = 0 OR IDANIMAL IN (SELECT IDANIMAL FROM `ANIMALESEXPEDIENTE` WHERE IDEXPEDIENTE IN (SELECT `IDEXPEDIENTE` FROM `PERSONASEXPEDIENTE` WHERE `IDPERSONA` = " .$id ." AND ESTADO = 'ACTIVO')))";
}
if($cat == "EDITAR"){
    $filtro = "";
}



if($received_data->query != '')
{
    $busca = " AND DOCUMENTO LIKE '%".$received_data->query."%'";
}
else
{
    $busca = "";
}





if($opcion == "publicos"){
    $query = "SELECT * FROM DOCUMENTO WHERE TIPO = 4" .$busca;
}
if($opcion == "propios"){
    $query = "SELECT * FROM DOCUMENTO WHERE IDPERSONA = " .$id .$busca;
}
if($opcion == "privados"){
    $query = "SELECT * FROM DOCUMENTO WHERE TIPO = 1" .$busca;
}
if($opcion == "formacion"){
    $query = "SELECT * FROM DOCUMENTO WHERE TIPO = 3" .$filtro .$busca;
}
if($opcion == "operativos"){
    $query = "SELECT * FROM DOCUMENTO WHERE TIPO = 2" .$filtro .$busca;
}

$resultado = array();

$consulta = mysql_query($query);

while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro;
}

echo json_encode($resultado);

?>
