<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

    
    $query2 = "SELECT * FROM EXPEDIENTETIPO";
    $consulta2 = mysql_query($query2);

    while($registro2 = mysql_fetch_array($consulta2)){
        $resultado2[]=$registro2;
    }
	

echo json_encode($resultado2);

?>