<?php

//action.php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

if($received_data->query != '')
{
	$query = "
	SELECT * FROM SEGUIMIENTOS
	WHERE SUCESO LIKE '%".$received_data->query."%' 
	OR FECHA LIKE '%".$received_data->query."%' 
	ORDER BY ID DESC
	";
}
else
{
	$query = "
	SELECT * FROM SEGUIMIENTOS 
	ORDER BY ID DESC
	";
}

$statement = $connect->prepare($query);

$statement->execute();

while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $row;
}

echo json_encode($data);

?>