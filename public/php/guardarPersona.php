<?php

    include("conect.php");

    $received_data = json_decode(file_get_contents("php://input"));

    $data = array();


    $query = "INSERT INTO PERSONAS (`ID`, `NIF`, `NOMBRE`, `APELLIDO1`, `APELLIDO2`, `DOMICILIO`, `EMAIL`, `TELEFONO`, `ORGANIZACION`, `TIPO`, `ESTADO`, `NOTAS`, `CAMPO1`, `CAMPO2`, `CAMPO3`, `ACTIVO`) VALUES ('','".$received_data->nif ."','".$received_data->nombre ."','".$received_data->apellido1 ."','".$received_data->apellido2 ."','".$received_data->domicilio ."','".$received_data->email ."','".$received_data->telefono ."','".$received_data->organizacion ."','".$received_data->tipo ."','','".$received_data->notas ."','".$received_data->campo1 ."','','','".$received_data->activo ."')";

    $consulta = mysql_query($query);


    $query = "SELECT ID FROM PERSONAS ORDER BY ID DESC LIMIT 1";

    $consulta = mysql_query($query);

    $resultado = "";

    while($registro = mysql_fetch_array($consulta)){
        $resultado=$registro["ID"];
    }

    echo $resultado;


?>