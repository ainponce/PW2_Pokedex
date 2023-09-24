<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = '';
$database = "pokedex";

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombrePokemon"];
    $altura = $_POST["alturaPokemon"];
    $peso = $_POST["pesoPokemon"];

    $conn = new mysqli($servername, $username, $password, $database) or die();

    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["size"] > 0) {
        $imagenPokemon = $_FILES["imagen"]["tmp_name"];
        $contenidoImagen = file_get_contents($imagenPokemon);

        if ($contenidoImagen === false) {
            echo "Error al cargar la imagen.";
            exit();
        }

        $sql = "UPDATE pokemon SET nombre = ?, peso = ?, imagen = ?, altura = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $altura, $contenidoImagen, $peso, $id);
    } else {
        $sql = "UPDATE pokemon SET nombre = ?, peso = ?, altura = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $altura, $peso, $id);
    }

    if ($stmt->execute()) {
        header('location: ../home.php');
        exit();
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
