<?php 

include('../conexion/conexion.php');

// Abrimos la conexión a la BD
$conexion = conectar();

// Consulta a la BD
$query = $conexion->prepare("SELECT autor_id, nombres, ape_paterno, ape_materno FROM autor");
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
    <title>Autores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/9cdb1aeb59.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-dark block-top bg-warning flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../index.html"><h1>CRUD - Laboratorio 7</h1></a>
    </nav>
    <h1 class="text-center p-3">CRUD - Autores</h1>
    
    <div class="container-fluid row">
    <form  action="agregar_autor.php" name="formulario" method="post" class="col-4 p-3">
        <h3 class="text-center text-secondary">Registro de Autores</h3>
        <div class="mb-3">
            <label for="" class="form-label">Nombres del Autor</label>
            <input type="text" class="form-control" name="nombres" required>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Apellido Paterno</label>
            <input type="text" class="form-control" name="ape_paterno" required>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Apellido materno</label>
            <input type="text" class="form-control" name="ape_materno">
        </div>
        
        <button type="submit" class="btn btn-primary" name="botonregistrar" value="Ok">Registrar</button>
    </form>
    
    <div class="col-8 p-4">
        <table  class="table table-striped">
            <thead class="bg-secondary">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellido Paterno</th>
                <th scope="col">Apellido Materno</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Mostrar el set de los registros que hay en la BD
                while($autor = $resultado->fetch_assoc()){
                    echo '<tr>';
                    echo '<td>'.$autor['autor_id'].'</td>';
                    echo '<td>'.$autor['nombres'].'</td>';
                    echo '<td>'.$autor['ape_paterno'].'</td>';
                    echo '<td>'.$autor['ape_materno'].'</td>';
                    echo '<td><a href="editar_autor.php?autor_id='.$autor['autor_id'].'" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>';
                    echo '<a href="eliminar_autor.php?autor_id='.$autor['autor_id'].'" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a></td>';
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