<?php

include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idPokemon = $_POST["id"];

    $stmt =  $conexion->prepare("DELETE FROM pokemons WHERE id = ?");
    $stmt->bind_param('i', $idPokemon);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close();
}

$conexion->close();