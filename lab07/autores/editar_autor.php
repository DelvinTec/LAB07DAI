<?php

include('../conexion/conexion.php');

// obtenemos el id
if (isset($_GET['autor_id'])) {
  $autor_id = $_GET['autor_id'];
} else {
  header('Location: autores.php');
}

// Vemos si se envió el formulario para editar autor
if (isset($_POST['submit'])) {
  // obtenemos los datos del formulario
  $nombres = $_POST['nombres'];
  $ape_paterno = $_POST['ape_paterno'];
  $ape_materno = $_POST['ape_materno'];

  // abrimos la conexion
  $conexion = conectar();

  // preparamos la consulta con prepared statement
  $query = $conexion->prepare("UPDATE autor SET nombres = ?, ape_paterno = ?, ape_materno = ? WHERE autor_id = ?");

  // asociamos los valores con los parametros usando bind_param
  $query->bind_param('sssi', $nombres, $ape_paterno, $ape_materno, $autor_id);

  // ejecutamos la consulta
  $msg = '';
  if ($query->execute()) {
    $msg = 'Autor actualizado';
  } else {
    $msg = 'No se pudo actualizar al autor';
  }

  // cerramos conexion
  desconectar($conexion);

  // redirigimos a autores.php.
  header('Location: autores.php?msg=' . urlencode($msg));
}

// obtenemos los datos del autor para mostrar en el formulario
$conexion = conectar();
$query = $conexion->prepare("SELECT nombres, ape_paterno, ape_materno FROM autor WHERE autor_id = ?");
$query->bind_param('i', $autor_id);
$query->execute();
$query->bind_result($nombres, $ape_paterno, $ape_materno);
$query->fetch();
desconectar($conexion);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Editar autor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
  <h1>Editar autor</h1>
  <form method="post" class="col-4 p-3">
    <h3 class="text-center text-secondary">Edición de Autores</h3>
    <label class="form-label">Nombres:</label>
    <input type="text" class="form-control" name="nombres" value="<?php echo $nombres; ?>" required><br><br>
    <label class="form-label">Apellido paterno:</label>
    <input type="text" class="form-control" name="ape_paterno" value="<?php echo $ape_paterno; ?>" required><br><br>
    <label class="form-label">Apellido materno:</label>
    <input type="text" class="form-control" name="ape_materno" value="<?php echo $ape_materno; ?>"><br><br>
    <input type="submit" class="btn btn-primary" name="submit" value="Actualizar">
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
