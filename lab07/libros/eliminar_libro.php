<?php

include('../conexion/conexion.php');

// obtenemos el id a eliminar
if (isset($_GET['libro_id'])) {
  $libro_id = $_GET['libro_id'];
} else {
  header('Location: libros.php');
}


$conexion = conectar();

// preparamos la consulta con preapred statement
$query = $conexion->prepare("DELETE FROM libro WHERE libro_id = ?");

// asociamos los valores de la consulta
$query->bind_param('i', $libro_id);

// ejecutamos el query
$msg = '';
if ($query->execute()) {
  $msg = 'Libro eliminado';
} else {
  $msg = 'No se pudo eliminar el libro';
}

// cerramos la conexion
desconectar($conexion);

// redirigimos a libros.php.
header('Location: libros.php?msg=' . urlencode($msg));
?>
