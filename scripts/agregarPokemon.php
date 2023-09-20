<?php

include ("database.php");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPokemon = $_POST["id"];
    $nombrePokemon = $_POST["nombre"];
    $imagenPokemon = $_FILES["imagen"]["tmp_name"];
    $contenidoImagen = file_get_contents($imagenPokemon);
    $alturaPokemon = $_POST["altura"];
    $pesoPokemon = $_POST["peso"];
    $tipo_idPokemon = $_POST["tipo_id"];
    $tipo2_idPokemon = $_POST["tipo2_id"];

    $stmt = $conexion->prepare("SELECT * FROM tipo_pokemon WHERE nombre=? ");
        $stmt->bind_param("s", $tipo_idPokemon);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();

        if ($resultado->num_rows == 1) {
            $row = $resultado->fetch_assoc();
            $tipo_idPokemon = $row["id"];     
        }

        $stmt = $conexion->prepare("SELECT * FROM tipo_pokemon WHERE nombre=? ");
        $stmt->bind_param("s", $tipo2_idPokemon);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();

        if ($resultado->num_rows == 1) {
            $row = $resultado->fetch_assoc();
            $tipo2_idPokemon = $row["id"];     
        }

    $sql = "INSERT INTO pokemon (id, nombre, imagen, altura, peso, tipo_id, tipo2_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("issddii", $idPokemon,$nombrePokemon, $contenidoImagen, $alturaPokemon, $pesoPokemon, $tipo_idPokemon, $tipo2_idPokemon);

        if ($stmt->execute()) {
            header("Location: home.php");
            exit;
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

