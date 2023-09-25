<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location: login.php");
    exit();
}

include("database.php");

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombrePokemon"];
    $altura = $_POST["alturaPokemon"];
    $peso = $_POST["pesoPokemon"];

    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["size"] > 0) {
        $imagenPokemon = $_FILES["imagen"]["tmp_name"];
        $contenidoImagen = file_get_contents($imagenPokemon);

        if ($contenidoImagen === false) {
            echo "Error al cargar la imagen.";
            exit();
        }

        $sql = "UPDATE pokemon SET nombre = ?, imagen = ?, altura = ?, peso = ?  WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssssi", $nombre,$contenidoImagen, $altura, $peso, $id);
    } else {
        $sql = "UPDATE pokemon SET nombre = ?, altura = ?, peso = ?  WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $altura, $peso, $id);
    }

    if ($stmt->execute()) {
        header('location: ../home.php');
        exit();
    } else {
        echo "Error al actualizar el registro: " . $conexion->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
