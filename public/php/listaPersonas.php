<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();
$resultado = [];
$resultado3 = [];


if($received_data->expediente != ''){

	$query3 = "SELECT IDPERSONA FROM PERSONASEXPEDIENTE WHERE IDEXPEDIENTE = ".$received_data->expediente;

	$consulta3 = mysql_query($query3);
	
	while($registro3 = mysql_fetch_array($consulta3)){
		$resultado3[]=$registro3["IDPERSONA"];
	
		$query2 = "SELECT * FROM PERSONAS WHERE ID = " .$registro3["IDPERSONA"];
	
		$consulta2 = mysql_query($query2);
		
		while($registro2 = mysql_fetch_array($consulta2)){
			$resultado[]=$registro2;
		}
	}

}else{
	if($received_data->query != '')
	{
		$query = "SELECT * FROM PERSONAS WHERE ID > 0 AND (NOMBRE LIKE '%".$received_data->query."%' OR APELLIDO1 LIKE '%".$received_data->query."%' OR APELLIDO2 LIKE '%".$received_data->query."%')";
	}
	else
	{
		$query = "SELECT * FROM PERSONAS WHERE ID > 0";
	}
}

$consulta = mysql_query($query);


while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro;
}

echo json_encode($resultado);
?>