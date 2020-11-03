<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


    $query = "INSERT INTO ".$received_data->tabla ." (`ID`, `".$received_data->tabla ."`) VALUES ('','".$received_data->query ."')";

    $consulta = mysql_query($query);




echo "Guardado";

?>