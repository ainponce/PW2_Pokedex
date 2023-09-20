<?php

include ("database.php");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPokemon = $_POST["id"];
    $nombrePokemon = $_POST["nombre"];
    $imagenPokemon = $_POST["imagen"];
    $alturaPokemon = $_POST["altura"];
    $pesoPokemon = $_POST["peso"];
    $tipo_idPokemon = $_POST["tipo_id"];
    $tipo2_idPokemon = $_POST["tipo2_id"];

    $sql = "INSERT INTO pokemon (id, nombre, imagen, altura, peso, tipo_id, tipo2_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isbddii", $idPokemon,$nombrePokemon, $imagenPokemon, $alturaPokemon, $pesoPokemon, $tipo_idPokemon, $tipo2_idPokemon);

        if ($stmt->execute()) {
            echo "Pokemon agregado correctamente.";
        } else {
            echo "Error al agregar el Pokemon: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }
} else {
    echo "Acceso no autorizado.";
}

$conexion->close();
?>

