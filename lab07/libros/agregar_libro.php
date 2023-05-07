<?php
include('../conexion/conexion.php');

if(isset($_POST['botonregistrar'])){
    // Desde acá de piden los datos del formulario
    $titulo = $_POST['titulo'];
    $autor_id = $_POST['autor_id'];
    $anio = $_POST['anio'];
    $especialidad = $_POST['especialidad'];
    $editorial = $_POST['editorial'];
    $url = $_POST['url'];

    // Insertar los datos del formulario en la base de datos
    $conexion = conectar();
    $query = $conexion->prepare("INSERT INTO libro (titulo, autor_id, anio, especialidad, editorial, url) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("sissss", $titulo, $autor_id, $anio, $especialidad, $editorial, $url);
    $query->execute();
    desconectar($conexion);

    // Redirigir al usuario a la página libros.php
    header("Location: libros.php");
    exit();
}
?>
