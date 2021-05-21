<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


if($received_data->id > 0){
    $query = "UPDATE INGRESOS SET FECHA = '".$received_data->fecha ."', TIPO_GASTO = '".$received_data->tipoG2 ."', NIF = '".$received_data->nif ."', CLIENTE = '".$received_data->nombre ."', DIRECCION = '".$received_data->direccion ."', POBLACION = '".$received_data->poblacion ."', POSTAL = '".$received_data->postal ."', EMAIL = '".$received_data->mail ."', FACTURA = '".$received_data->factura ."', BASE = '" .$received_data->base ."', IVA_POR = '".$received_data->ivaPor ."', IVA = '".$received_data->iva ."', TIPO_RETENCION = '".$received_data->retencionT ."', RETENCION_POR = '".$received_data->retencionPor ."', LIQUIDO = '".$received_data->liquido ."', TIPO = '".$received_data->tipo ."', DESCRIPCION = '".$received_data->descripcion ."', TRIBUTA = '".$received_data->tributa ."', PAGADO = '".$received_data->pagado ."', RETENCION = '".$received_data->retencion ."' WHERE ID = " .$received_data->id;

    $consulta = mysql_query($query);
}else{
    $query = "INSERT INTO INGRESOS (`FECHA`, `TIPO_GASTO`, `NIF`, `CLIENTE`, `DIRECCION`, `POBLACION`, `POSTAL`, `EMAIL`, `FACTURA`, `BASE`, `IVA_POR`, `IVA`, `TIPO_RETENCION`, `RETENCION_POR`, `LIQUIDO`, `TIPO`, `INSERCCION`, `DESCRIPCION`, `TRIBUTA`, `PAGADO`, `RETENCION`) VALUES ('".$received_data->fecha ."','".$received_data->tipoG2 ."','".$received_data->nif ."','".$received_data->nombre ."','".$received_data->direccion ."','".$received_data->poblacion ."','".$received_data->postal ."','".$received_data->mail ."','".$received_data->factura ."','".$received_data->base ."','".$received_data->ivaPor ."','".$received_data->iva ."','".$received_data->retencionT ."','".$received_data->retencionPor ."','".$received_data->liquido ."','".$received_data->tipo ."','".$received_data->inserccion ."','".$received_data->descripcion ."','".$received_data->tributa ."','".$received_data->pagado ."','".$received_data->retencion ."')";

    $consulta = mysql_query($query);
}



echo "Factura Guardada";

?>