<?php

include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idPokemon = $_POST["id"];
    $nombrePokemon = $_POST["nombrePokemon"];
    $tipoPokemon = $_POST["tipoPokemon"];

    $stmt = $conexion->prepare("UPDATE pokemons set  nombre=?, tipo=? WHERE id=?");
    $stmt->bind_param("ssi", $nombrePokemon,$tipoPokemon,$idPokemon);
    $stmt->execute();
    $stmt->close();
}

$conexion->close();