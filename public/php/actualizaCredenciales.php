<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();


if($received_data->id > 0){
    $query = "UPDATE PASSWORD SET USUARIO = '".$received_data->usuario ."', PASSWORD = '".$received_data->contraseña ."' WHERE ID = " .$received_data->id;

    $consulta = mysql_query($query);
}else{
    $query = "INSERT INTO PASSWORD (`USUARIO`, `PASSWORD`, `ID`, `IDPERSONA`, `TIPO`) VALUES ('".$received_data->usuario ."','".$received_data->contraseña ."','".$received_data->id ."','".$received_data->persona ."','1')";

    $consulta = mysql_query($query);
}





	
	
$to = "jquedi@hotmail.com";
	
$subject = "Nuevas Credenciales Arikel";

$headers = "From: direccion@arikelk9.com \r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = "Sus nuevas credenciales para iniciar sesion en la App de Arikel son: </br>
    User: " .$received_data->usuario ."</br>
    Password: " .$received_data->contraseña ."</br>
    Enlace de la App: http://app.arikelk9.es/
";







mail(utf8_encode($to),utf8_encode($subject),utf8_encode($message),utf8_encode($headers));









echo "Credenciales actualizadas";

?>