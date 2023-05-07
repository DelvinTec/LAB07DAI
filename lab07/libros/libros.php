<?php 

include('../conexion/conexion.php');

// Abrimos la conexión a la BD
$conexion = conectar();

// Consulta a la BD
$query = $conexion->prepare("SELECT libro.libro_id, libro.titulo, autor.nombres, autor.ape_paterno, autor.ape_materno, libro.anio, libro.especialidad, libro.editorial, libro.url
FROM libro
JOIN autor ON libro.autor_id = autor.autor_id"
);
$query->execute();
$resultado = $query->get_result();


// Cerramos la conexion
desconectar($conexion);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/9cdb1aeb59.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-dark block-top bg-warning flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../index.html"><h1>CRUD - Laboratorio 7</h1></a>
    </nav>
    <h1 class="text-center p-3">CRUD - Libros</h1>
    
    <div class="container-fluid row">
    <form  action="agregar_libro.php" name="formulario" method="post" class="col-4 p-3">
        <h3 class="text-center text-secondary">Registro de Libros</h3>
        <div class="mb-3">
            <label for="" class="form-label">Título</label>
            <input type="text" class="form-control" name="titulo" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Autor:</label>
            <select class="form-select" name="autor_id" required>
                <option value="">Selecciona un autor</option>
                <?php
                $conexion = conectar();
                $query = $conexion->prepare("SELECT autor_id, nombres, ape_paterno, ape_materno FROM autor");
                $query->execute();
                $query->bind_result($autor_id, $nombres, $ape_paterno, $ape_materno);
                $autor_seleccionado = ''; // Variable para guardar el autor seleccionado
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
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Año</label>
            <input type="text" class="form-control" name="anio" required>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Especialidad</label>
            <input type="text" class="form-control" name="especialidad" required>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Editorial</label>
            <input type="text" class="form-control" name="editorial" required>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">URL</label>
            <input type="text" class="form-control" name="url">
        </div>
        <button type="submit" class="btn btn-primary" name="botonregistrar" value="Ok">Registrar</button>
    </form>
    
    <div class="col-8 p-4">
        <table  class="table table-striped">
            <thead class="bg-secondary">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Titulo</th>
                <th scope="col">Autor</th>
                <th scope="col">Año</th>
                <th scope="col">Especialidad</th>
                <th scope="col">Editorial</th>
                <th scope="col">URL</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Mostrar el set de los registros que hay en la BD
                while($libro = $resultado->fetch_assoc()){
                    echo '<tr>';
                    echo '<td>'.$libro['libro_id'].'</td>';
                    echo '<td>'.$libro['titulo'].'</td>';
                    echo '<td>'.$libro['nombres'].' '.$libro['ape_paterno'].' '.$libro['ape_materno'].'</td>';
                    echo '<td>'.$libro['anio'].'</td>';
                    echo '<td>'.$libro['especialidad'].'</td>';
                    echo '<td>'.$libro['editorial'].'</td>';
                    echo '<td><a href="'.$libro['url'].'" target="_blank">'.substr($libro['url'], 0, 17).'...</a></td>';
                    echo '<td><a href="editar_libro.php?libro_id='.$libro['libro_id'].'" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>';
                    echo '<a href="eliminar_libro.php?libro_id='.$libro['libro_id'].'" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a></td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>