<?php

    include("conect.php");

    $received_data = json_decode(file_get_contents("php://input"));

    $data = array();

        $query = "UPDATE `INGRESOS` SET `REVISADO`='SI' WHERE ID = ".$received_data->id;

        $consulta = mysql_query($query);




    


    echo "Factura revisada";


?>