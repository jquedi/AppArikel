<?php

    include("conect.php");

    $received_data = json_decode(file_get_contents("php://input"));

    $data = array();

    if($received_data->id > 0){
        $query = "UPDATE `EXPEDIENTES` SET `CODIGO`='".$received_data->codigoE ."',`DESCRIPCION`='".$received_data->descripcionE ."',`LOCALIZACION`='".$received_data->localizacionE ."',`INICIO`='".$received_data->fecha ."',`TIPO`='".$received_data->tipoE ."',`ESTADO`='".$received_data->estadoE ."',`NOTAS`='".$received_data->notasE ."',`CAMPO1`='".$received_data->campo1E ."',`ACTIVO`='".$received_data->activoE ."' WHERE ID = ".$received_data->id;

        $consulta = mysql_query($query);



    }else{
        $query = "INSERT INTO EXPEDIENTES (`ID`, `CODIGO`, `DESCRIPCION`, `LOCALIZACION`, `INICIO`, `FINAL`, `TIPO`, `ESTADO`, `NOTAS`, `CAMPO1`, `CAMPO2`, `CAMPO3`, `ACTIVO`) VALUES ('','".$received_data->codigoE ."','".$received_data->descripcionE ."','".$received_data->localizacionE ."','".$received_data->fecha ."','','".$received_data->tipoE ."','".$received_data->estadoE ."','".$received_data->notasE ."','".$received_data->campo1E ."','','','".$received_data->activoE ."')";


        $consulta = mysql_query($query);

    }


    


    echo "Guardado";


?>