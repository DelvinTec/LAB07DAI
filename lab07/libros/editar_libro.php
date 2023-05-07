<?php

include('../conexion/conexion.php');

// Primero recibimos el id a editar
if (isset($_GET['libro_id'])) {
  $libro_id = $_GET['libro_id'];
} else {
  header('Location: libros.php');
}

// con submit ingresamos los nuevos datos
if (isset($_POST['submit'])) {
  // Estos son los nuevos datos
  $titulo = $_POST['titulo'];
  $autor_id = $_POST['autor_id'];
  $anio = $_POST['anio'];
  $especialidad = $_POST['especialidad'];
  $editorial = $_POST['editorial'];
  $url = $_POST['url'];

  // abrimos la conexión
  $conexion = conectar();

  // el sql con prepared statement
  $query = $conexion->prepare("UPDATE libro SET titulo = ?, autor_id = ?, anio = ?, especialidad = ?, editorial = ?, url = ? WHERE libro_id = ?");

  // asociamos los valores de la consulta con los parámetros usando bind_param
  $query->bind_param('ssssssi', $titulo, $autor_id, $anio, $especialidad, $editorial, $url, $libro_id);

  // ejecutamos la consulta y verificar si se actualizó correctamente el libro
  $msg = '';
  if ($query->execute()) {
    $msg = 'libro actualizado';
  } else {
    $msg = 'No se pudo actualizar el libro';
  }

  // cerramos la conexión a la base de datos
  desconectar($conexion);

  // redirigimos al usuario a la página de resultados.
  header('Location: libros.php?msg=' . urlencode($msg));
}

// Paso 10: Obtener los datos del libro para mostrar en el formulario
$conexion = conectar();
$query = $conexion->prepare("SELECT titulo, autor_id, anio, especialidad, editorial, url FROM libro WHERE libro_id = ?");
$query->bind_param('i', $libro_id);
$query->execute();
$query->bind_result($titulo, $autor_id, $anio, $especialidad, $editorial, $url);
$query->fetch();
desconectar($conexion);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Editar libro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
  <h1>Editar libro</h1>
  <form method="post" class="col-4 p-3">
    <h3 class="text-center text-secondary">Edición de Libros</h3>
    <label class="form-label">Titulo:</label>
    <input type="text" class="form-control" name="titulo" value="<?php echo $titulo; ?>" required><br><br>
    <label class="form-label">Autor:</label>
            <select class="form-select" name="autor_id" required>
                <option value="">Selecciona un autor</option>
                <?php
                $conexion = conectar();
                $query = $conexion->prepare("SELECT autor_id, nombres, ape_paterno, ape_materno FROM autor");
                $query->execute();
                $query->bind_result($autor_id, $nombres, $ape_paterno, $ape_materno);
                $autor_seleccionado = $autor_id; // Variable para guardar el autor seleccionado
                while ($query->fetch()) {
                    $nombre_completo = $nombres . ' ' . $ape_paterno . ' ' . $ape_materno;
                    echo '<option value="' . $autor_id . '"';
                    if ($autor_id == $autor_seleccionado) { // Comparamos con $autor_seleccionado
                        echo ' selected';
                    }
                    echo '>' . $nombre_completo . '</option>';
                }
                desconectar($conexion);
                ?>
            </select>
    <label class="form-label">Año:</label>
    <input type="text" class="form-control" name="anio" value="<?php echo $anio; ?>" required><br><br>
    <label class="form-label">Especialidad:</label>
    <input type="text" class="form-control" name="especialidad" value="<?php echo $especialidad; ?>"><br><br>
    <label class="form-label">Editorial:</label>
    <input type="text" class="form-control" name="editorial" value="<?php echo $editorial; ?>"><br><br>
    <label class="form-label">url:</label>
    <input type="text" class="form-control" name="url" value="<?php echo $url; ?>"><br><br>
    <input type="submit" class="btn btn-primary" name="submit" value="Actualizar">
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
