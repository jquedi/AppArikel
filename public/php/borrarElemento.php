<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$query = "DELETE FROM " .$received_data->tabla ." WHERE ID = " .$received_data->id;

    
$consulta = mysql_query($query);

echo "Elemento eliminado";
?>