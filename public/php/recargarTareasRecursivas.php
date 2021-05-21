<?php

include("conect.php");

$received_data = json_decode(file_get_contents("php://input"));

$data = array();

$fecha = $received_data->fecha;

$i = 0;

$query = "SELECT ID FROM ALERTASANIMALES";

$consulta = mysql_query($query);

while($registro = mysql_fetch_array($consulta)){
    $resultado[]=$registro["ID"];

    $query2 = "SELECT * FROM ALERTASANIMALES WHERE ID = ".$registro["ID"] ;


    $consulta2 = mysql_query($query2);
    
    while($registro2 = mysql_fetch_array($consulta2)){
        $resultado2[]=$registro2;


        $inicio = $resultado2[$i][4];
        $fin = $resultado2[$i][5];

        // $porciones = explode("-", $inicio);
        // $año = $porciones[0];
        // $mes = $porciones[1];
        // $dia = $porciones[2];


        
//sumo 1 día
// echo date("d-m-Y",strtotime($fecha."+ 10 days")); 


        // if($inicio > $fecha){
        //     echo $inicio;
        // }
        // if($inicio < $fecha){
        //     echo $fecha;
        // }




        if($resultado2[$i][6] > 0 && $resultado2[$i][10] == "FINALIZADA"){

            if($resultado2[$i][7] == "DIAS"){

                $cant = "+ " .$resultado2[$i][6] ." days";

                $aux = date("Y-m-d",strtotime($inicio.$cant));
                $aux2 = date("Y-m-d",strtotime($fin.$cant));

                if($aux <= $fecha){
                    

                    $query3 = "UPDATE `ALERTASANIMALES` SET `FECHAINICIO` = '" .$aux ."', `FECHALIMITE` = '" .$aux2 ."', `ESTADO` = 'ACTIVO', `USUARIO` = 0 WHERE ID = ".$resultado2[$i][0];
                    $consulta3 = mysql_query($query3);


                }

                
            }
            if($resultado2[$i][7] == "MESES"){

                $cant = "+ " .$resultado2[$i][6] ." month";

                $aux = date("Y-m-d",strtotime($inicio.$cant));
                $aux2 = date("Y-m-d",strtotime($fin.$cant));

                if($aux <= $fecha){
                    $query3 = "UPDATE `ALERTASANIMALES` SET `FECHAINICIO` = '" .$aux ."', `FECHALIMITE` = '" .$aux2 ."', `ESTADO` = 'ACTIVO', `USUARIO` = 0 WHERE ID = ".$resultado2[$i][0];
                    $consulta3 = mysql_query($query3);
                }
            }
            if($resultado2[$i][7] == "AÑOS"){

                $cant = "+ " .$resultado2[$i][6] ." year";

                $aux = date("Y-m-d",strtotime($inicio.$cant));
                $aux2 = date("Y-m-d",strtotime($fin.$cant));

                if($aux <= $fecha){
                    $query3 = "UPDATE `ALERTASANIMALES` SET `FECHAINICIO` = '" .$aux ."', `FECHALIMITE` = '" .$aux2 ."', `ESTADO` = 'ACTIVO', `USUARIO` = 0 WHERE ID = ".$resultado2[$i][0];
                    $consulta3 = mysql_query($query3);
                }
            }
          
        }

        // $query3 = "UPDATE `ANIMALES` SET `ALERTAS` = " .$registro2['CONTADOR'] ." WHERE ID = ".$registro["ID"];
        // $consulta3 = mysql_query($query3);

        $i = $i + 1;

    }


	
}


?>