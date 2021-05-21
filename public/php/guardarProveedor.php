<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


if($received_data->id > 0){
    $query = "UPDATE PROVEEDORES SET TIPO_GASTO = '".$received_data->tipoG2 ."', NIF = '".$received_data->nif ."', CLIENTE = '".$received_data->nombre ."', DIRECCION = '".$received_data->direccion ."', POBLACION = '".$received_data->poblacion ."', POSTAL = '".$received_data->postal ."', EMAIL = '".$received_data->mail ."', TIPO = '".$received_data->tipo ."', CAMPO1 = '".$received_data->campo1 ."', CAMPO2 = '".$received_data->campo2 ."', CAMPO3 = '".$received_data->campo3 ."' WHERE ID = " .$received_data->id;

    $consulta = mysql_query($query);
}else{
    $query = "INSERT INTO `PROVEEDORES`(`ID`, `NIF`, `CLIENTE`, `DIRECCION`, `POBLACION`, `POSTAL`, `EMAIL`, `TIPO`, `TIPO_GASTO`, `TIPO_RETENCION`, `CAMPO1`, `CAMPO2`, `CAMPO3`) VALUES ('','".$received_data->nif ."','".$received_data->nombre ."','".$received_data->direccion ."','".$received_data->poblacion ."','".$received_data->postal ."','".$received_data->mail ."','".$received_data->tipo ."','".$received_data->tipoG2 ."','','".$received_data->campo1 ."','".$received_data->campo2 ."','".$received_data->campo3 ."')";

    $consulta = mysql_query($query);
}



echo "Plantilla Guardada";

?>
