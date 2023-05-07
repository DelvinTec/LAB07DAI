<?php

include('../conexion/conexion.php');

// Obtenemos los valores del formulario
$nombres = $_POST['nombres'];
$ape_paterno = $_POST['ape_paterno'];
$ape_materno = $_POST['ape_materno'];

// Abrimos la conexión a la base de datos
$conexion = conectar();

// Consulta a la base de datos
$query = $conexion->prepare("INSERT INTO autor (nombres, ape_paterno, ape_materno) VALUES (?,?,?)");
$query->bind_param('sss', $nombres, $ape_paterno, $ape_materno); //match tipo de dato con el dato
$msg = '';
if ($query->execute()){
    $msg = 'Autor registrado';
}
else {
    $msg = 'No se pudo registrar al autor';
}
header('Location: autores.php?msg=' . urlencode($msg));

// Cerramos la conexión a la BD
desconectar($conexion);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso Autor</title>
</head>
<body>
    <h1>Ingreso Autor</h1>
    <h3><?php echo $msg ?></h3>
    <a href="autores.php" class="btn btn-primary">Regresar</a>

</body>
</html>