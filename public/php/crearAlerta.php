<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$nombres = $received_data->checkedNames;

for($i = 0; $i < count($nombres); $i++){

        $query = "INSERT INTO ALERTAS(ID, FECHA, HASTA, ALERTA, ACTIVA, USUARIO, IDPERSONA, TIPO) VALUES ('','" .$received_data->actual ."','" .$received_data->fecha ."','" .$received_data->argumento ."','SI','','" .$nombres[$i] ."','')";

        $consulta = mysql_query($query);

        
}
echo "Alerta creada";
?>