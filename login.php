<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$query = "SELECT IDPERSONA FROM PASSWORD WHERE USUARIO = '".$received_data->query ."' AND PASSWORD = '".$received_data->query2 ."'";

$consulta = mysql_query($query);

$resultado = "0";

while($registro = mysql_fetch_array($consulta)){
	$resultado=$registro["IDPERSONA"];
	
}

echo $resultado;

?>