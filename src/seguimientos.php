<?php

//action.php

$connect = new PDO("mysql:host=rdbms.strato.de; dbname=DB4245417", "U4245417", "George21444267");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

if($received_data->query != '')
{
	$query = "SELECT * FROM SEGUIMIENTOS WHERE SUCESO LIKE '%".$received_data->query."%' OR FECHA LIKE '%".$received_data->query."%' ORDER BY ID DESC";
}
else
{
	$query = "SELECT * FROM SEGUIMIENTOS ORDER BY ID DESC";
}

$statement = $connect->prepare($query);

$statement->execute();

while($row = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $row;
}

echo json_encode($data);

?>