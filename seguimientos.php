<?php

//action.php

/*$connect = new PDO("mysql:host=rdbms.strato.de; dbname=DB4245417", "U4245417", "George21444267");*/

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

if($received_data->query != '')
{
	$query = "SELECT * FROM SEGUIMIENTOS WHERE IDPERSONA = '".$received_data->usuario ."' AND (SUCESO LIKE '%".$received_data->query."%' OR REQUERIMIENTO LIKE '%".$received_data->query."%' OR FECHA LIKE '%".$received_data->query."%') ORDER BY FECHA DESC";
}
else
{
	$query = "SELECT * FROM SEGUIMIENTOS WHERE IDPERSONA = '".$received_data->usuario ."' ORDER BY FECHA DESC";
}


$consulta = mysql_query($query);

$resultado = array();

while($registro = mysql_fetch_array($consulta)){
	$resultado[]=$registro;
	
}

echo json_encode($resultado);

?>