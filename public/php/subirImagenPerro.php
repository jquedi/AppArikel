<?php
$target_dir = "/app";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;



try {
   if (move_uploaded_file($_FILES['fileToUpload']['name'], $target_file)) {
      echo "El archivo es válido y se cargó correctamente.<br><br>";
     echo"<a href='".$target_file."' target='_blank'><img src='".$target_file."' width='150'></a>";
    } else {
       echo "La subida ha fallado";
    }
    echo "</div>";
} catch (Exception $e) {
   echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}







// $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// // Check if image file is a actual image or fake image
// if(isset($_POST["submit"])) {
//   $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//   if($check !== false) {
//     echo "File is an image - " . $check["mime"] . ".";
//     $uploadOk = 1;
//   } else {
//     echo "File is not an image.";
//     $uploadOk = 0;
//   }
// }
// echo "Prueba";



// include("conect.php");

// $received_data = json_decode(file_get_contents("php://input"));

// $data = array();

// $query = "SELECT * FROM " .$received_data->tabla;

// $consulta = mysql_query($query);

// $resultado = [];

// while($registro = mysql_fetch_array($consulta)){
//     $resultado[]=$registro;
// }

// echo "json_encode($resultado)";






?>
