<?php

$servername="localhost:3307";
$db="pokedex";
$user="root";
$pass="";

$conexion= mysqli_connect($servername, $user, $pass, $db);

if($conexion->connect_error){
    die("conexion fallida");
}

mysqli_set_charset($conexion, "utf8");