<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


    $query = "INSERT INTO PERMISOS2 (`PERSONAID`, `ADMINISTRADOR`, `ALERTAS`, `ALERTASVER`, `EVENTOS`, `DOCUMENTOS`, `SEGUIMIENTOS`, `FACTURAS`, `DOCUMENTOPRIVADO`, `DOCUMENTOFORMACION`, `DOCUMENTOOPERATIVO`, `MANTENIMIENTO`, `SEGUIMIENTOST`) VALUES ('".$received_data->persona ."','".$received_data->admin ."','".$received_data->alertas ."','".$received_data->alertasV ."','".$received_data->eventos ."','".$received_data->documentos ."','".$received_data->seguimientos ."','".$received_data->facturas ."','".$received_data->documentos2 ."','".$received_data->documentos3 ."','".$received_data->documentos4 ."','".$received_data->mantenimiento ."','".$received_data->seguimientosT ."') ON DUPLICATE KEY UPDATE ADMINISTRADOR = VALUES(ADMINISTRADOR), ALERTAS = VALUES(ALERTAS), ALERTASVER = VALUES(ALERTASVER), EVENTOS = VALUES(EVENTOS), DOCUMENTOS = VALUES(DOCUMENTOS), SEGUIMIENTOS = VALUES(SEGUIMIENTOS), FACTURAS = VALUES(FACTURAS), DOCUMENTOPRIVADO = VALUES(DOCUMENTOPRIVADO), DOCUMENTOFORMACION = VALUES(DOCUMENTOFORMACION), DOCUMENTOOPERATIVO = VALUES(DOCUMENTOOPERATIVO), MANTENIMIENTO = VALUES(MANTENIMIENTO), SEGUIMIENTOST = VALUES(SEGUIMIENTOST)";

    $consulta = mysql_query($query);




echo "Guardado";

?>