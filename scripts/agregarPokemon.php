<?php

include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idPokemon = $_POST["id"];
    $nombrePokemon = $_POST["nombrePokemon"];
    $tipoPokemon = $_POST["tipoPokemon"];

    $stmt =  $conexion->prepare("INSERT INTO `pokemons`(`id`,`nombre`,`tipo`) VALUES (?,?,?)");
    $stmt->bind_param('iss', $idPokemon,$nombrePokemon,$tipoPokemon);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close();

    //http_response_code(201);

}

$conexion->close();
