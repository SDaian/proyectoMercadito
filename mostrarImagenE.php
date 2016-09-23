<?php

require_once 'sistema/constantes.php';
// se recibe el valor que identifica la imagen en la tabla
$id = $_GET['id'];
$link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME)
or die("Error " . mysqli_error($link));
// se recupera la información de la imagen
$sql = "SELECT contenidoimagen, tipoimagen
FROM productos
WHERE idProducto=".$_GET['id'] .";";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
mysqli_close($link);
// se imprime la imagen y se le avisa al navegador que lo que se está
// enviando no es texto, sino que es una imagen un tipo en particular
header("Content-type: image/jpeg");
echo $row["contenidoimagen"];
?>