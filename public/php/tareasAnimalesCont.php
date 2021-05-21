
<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "SELECT ID FROM ANIMALES";

$consulta = mysql_query($query);

while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro["ID"];

    $query2 = "SELECT COUNT(*) AS CONTADOR FROM ALERTASANIMALES WHERE ANIMAL = ".$registro["ID"] ." AND ESTADO = 'ACTIVO'" ;

    $consulta2 = mysql_query($query2);
    
    while($registro2 = mysql_fetch_array($consulta2)){
        $resultado2[]=$registro2["CONTADOR"];
        
        $query3 = "UPDATE `ANIMALES` SET `ALERTAS` = " .$registro2['CONTADOR'] ." WHERE ID = ".$registro["ID"];
        $consulta3 = mysql_query($query3);

    }
	
}


?>