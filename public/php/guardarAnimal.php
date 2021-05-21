<?php

    include("conect.php");

    $received_data = json_decode(file_get_contents("php://input"));

    $data = array();

    if($received_data->id > 0){
        $query = "UPDATE `ANIMALES` SET `CODIGO`='".$received_data->codigoA ."',`NOMBRE`='".$received_data->nombreA ."',`RAZA`='".$received_data->razaA ."',`CHIP`='".$received_data->chipA ."',`NACIMIENTO`='".$received_data->nacimientoA ."',`UBICACION`='".$received_data->ubicacionA ."',`NOTAS`='".$received_data->notasA ."',`ALIMENTACION`='".$received_data->alimentacionA ."',`TIPO`='".$received_data->tipoA ."',`CAMPO1`='".$received_data->campo1A ."',`CAMPO2`='',`CAMPO3`='',`ESTADO`='".$received_data->estadoA ."',`ACTIVO`='".$received_data->activoA ."' WHERE ID = ".$received_data->id;

        $consulta = mysql_query($query);



    }else{
        $query = "INSERT INTO ANIMALES (`ID`, `CODIGO`, `NOMBRE`, `RAZA`, `CHIP`, `NACIMIENTO`, `UBICACION`, `NOTAS`, `ALIMENTACION`, `TIPO`, `CAMPO1`, `CAMPO2`, `CAMPO3`, `ESTADO`, `ACTIVO`) VALUES ('','".$received_data->codigoA ."','".$received_data->nombreA ."','".$received_data->razaA ."','".$received_data->chipA ."','".$received_data->nacimientoA ."','".$received_data->ubicacionA ."','".$received_data->notasA ."','".$received_data->alimentacionA ."','".$received_data->tipoA ."','".$received_data->campo1A ."','','','".$received_data->estadoA ."','".$received_data->activoA ."')";


        $consulta = mysql_query($query);

    }


    


    echo "Guardado";


?>