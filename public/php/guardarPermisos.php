<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


    $query = "INSERT INTO PERMISOS2 (`PERSONAID`, `ADMINISTRADOR`, `ALERTAS`, `ALERTASVER`, `EVENTOS`, `DOCUMENTOS`, `SEGUIMIENTOS`, `FACTURAS`) VALUES ('".$received_data->persona ."','".$received_data->admin ."','".$received_data->alertas ."','".$received_data->alertasV ."','".$received_data->eventos ."','".$received_data->documentos ."','".$received_data->seguimientos ."','".$received_data->facturas ."') ON DUPLICATE KEY UPDATE ADMINISTRADOR = VALUES(ADMINISTRADOR), ALERTAS = VALUES(ALERTAS), ALERTASVER = VALUES(ALERTASVER), EVENTOS = VALUES(EVENTOS), DOCUMENTOS = VALUES(DOCUMENTOS), SEGUIMIENTOS = VALUES(SEGUIMIENTOS), FACTURAS = VALUES(FACTURAS)";

    $consulta = mysql_query($query);




echo "Guardado";

?>