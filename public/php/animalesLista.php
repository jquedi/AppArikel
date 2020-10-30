<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "SELECT IDEXPEDIENTE FROM PERSONASEXPEDIENTE WHERE IDPERSONA = '".$received_data->usuario ."' AND ESTADO = 'ACTIVO'";

$consulta = mysql_query($query);

while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro["IDEXPEDIENTE"];

    $query2 = "SELECT IDANIMAL FROM ANIMALESEXPEDIENTE WHERE IDEXPEDIENTE = '".$registro["IDEXPEDIENTE"] ."' AND ESTADO = 'TRABAJANDO'";

    $consulta2 = mysql_query($query2);
    
    while($registro2 = mysql_fetch_array($consulta2)){
        $resultado2[]=$registro2["IDANIMAL"];
        
        $query3 = "SELECT * FROM ANIMALES WHERE ID = ".$registro2['IDANIMAL'];
        $consulta3 = mysql_query($query3);
    
        while($registro3 = mysql_fetch_array($consulta3)){
            $resultado3[]=$registro3;
        }
        
    }
	
}

echo json_encode($resultado3);

?>
