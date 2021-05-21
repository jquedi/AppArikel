<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$query = "DELETE FROM DOCUMENTO WHERE ID = " .$received_data->query;

    
$consulta = mysql_query($query);


?>