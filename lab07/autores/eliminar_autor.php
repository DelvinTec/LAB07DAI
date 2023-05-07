<?php

include('../conexion/conexion.php');

// obtenemos el id
if (isset($_GET['autor_id'])) {
  $autor_id = $_GET['autor_id'];
} else {
  header('Location: autores.php');
}

// abrimos conexion
$conexion = conectar();

// usamos prepared statement
$query = $conexion->prepare("DELETE FROM autor WHERE autor_id = ?");

// asociamos los valores con los parametros
$query->bind_param('i', $autor_id);

// ejercutamos la consulta y damos un mensaje
$msg = '';
if ($query->execute()) {
  $msg = 'Autor eliminado';
} else {
  $msg = 'No se pudo eliminar al autor';
}

// cerramos la conexión a la base de datos
desconectar($conexion);

// redirigir al usuario a la página de autores.php.
header('Location: autores.php?msg=' . urlencode($msg));
?>
