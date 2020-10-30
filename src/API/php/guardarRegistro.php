<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "SELECT ID FROM EXPEDIENTES WHERE DESCRIPCION = '".$received_data->expediente ."'";

$consulta = mysql_query($query);

$expediente = "";

while($registro = mysql_fetch_array($consulta)){
	$expediente=$registro["ID"];
	
}


$query = "SELECT ID FROM ANIMALES WHERE NOMBRE = '".$received_data->animal ."'";

$consulta = mysql_query($query);

$animal = "";

while($registro = mysql_fetch_array($consulta)){
	$animal=$registro["ID"];
	
}


if($received_data->id > 0){
    $query = "UPDATE SEGUIMIENTOS SET SUCESO = '".$received_data->suceso ."', ACTUACION = '" .$received_data->actuacion ."', ESTADO = 'PENDIENTE' WHERE ID = " .$received_data->id;

    $consulta = mysql_query($query);
}else{
    $query = "INSERT INTO SEGUIMIENTOS (`REFERENCIA`, `FECHA`, `IDEXPEDIENTE`, `IDPERSONA`, `IDANIMAL`, `REQUERIMIENTO`, `SUCESO`, `ACTUACION`, `TIPO`, `CAMPO1`, `CAMPO2`, `CAMPO3`, `ESTADO`) VALUES ('','".$received_data->fecha ."','".$expediente ."','".$received_data->persona ."','".$animal ."','".$received_data->requerimiento ."','".$received_data->suceso ."','".$received_data->actuacion ."','".$received_data->tipo ."','".$received_data->campo1 ."','','','PENDIENTE')";

    $consulta = mysql_query($query);
}



echo "Registro Guardado";

?>