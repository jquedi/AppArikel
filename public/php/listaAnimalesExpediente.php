<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();
$resultado = [];
$resultado3 = [];









$query3 = "SELECT IDANIMAL FROM ANIMALESEXPEDIENTE WHERE IDEXPEDIENTE = ".$received_data->exp;

$consulta3 = mysql_query($query3);

while($registro3 = mysql_fetch_array($consulta3)){
    $resultado3[]=$registro3["IDANIMAL"];

    if($received_data->query != '')
    {
        $query2 = "SELECT * FROM ANIMALES WHERE ID = " .$registro3["IDANIMAL"] ." AND NOMBRE LIKE '%".$received_data->query."%'";
    }
    else
    {
        $query2 = "SELECT * FROM ANIMALES WHERE ID = " .$registro3["IDANIMAL"];
    }

    $consulta2 = mysql_query($query2);
    
    while($registro2 = mysql_fetch_array($consulta2)){
        $resultado[]=$registro2;
    }
}

echo json_encode($resultado);
?>