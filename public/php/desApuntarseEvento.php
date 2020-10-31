<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$query = "DELETE FROM PERSONASEVENTO WHERE IDPERSONA = " .$received_data->usuario ." AND IDEVENTO = " .$received_data->idEvento;

    
$consulta = mysql_query($query);


echo "Se ha dado de baja en el evento.";

?>
