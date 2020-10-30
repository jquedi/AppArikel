<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$query = "INSERT INTO PERSONASEVENTO (`IDPERSONA`, `IDEVENTO`, `TIPO`, `ESTADO`) VALUES ('".$received_data->usuario ."','".$received_data->idEvento ."','GUIA','SOLICITADO')";

    
$consulta = mysql_query($query);


echo "Se ha envidado la solicitud para unirse al evento.";

?>
