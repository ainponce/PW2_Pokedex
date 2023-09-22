<?php

include("database.php");

$sql = "SELECT * FROM pokemon WHERE 1";

if (isset($_POST['tipo']) && !empty($_POST['tipo'])) {
    $tipoSeleccionado = $_POST['tipo'];
    $sql .= " AND (tipo_id = '$tipoSeleccionado' OR tipo2_id = '$tipoSeleccionado')";
}

if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
    $nombreSeleccionado = $_POST['nombre'];
    $sql .= " AND nombre LIKE '%$nombreSeleccionado%'";
}

$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4 mb-4">';
        echo '<div class="card text-center">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row["nombre"] . '</h5>';
        echo '<img src="data:image/jpeg;base64,' . base64_encode($row["imagen"]) . '" class="imagen-pokemon mx-auto" alt="' . $row["nombre"] . '">';
        echo '<p class="card-text">Nro: ' . $row["id"] . '</p>';
        echo '<p class="card-text">Altura: ' . $row["altura"] . ' cm</p>';
        echo '<p class="card-text">Peso: ' . $row["peso"] . ' kg</p>';

        if (!empty($row["tipo2_id"])) {
            $tipo1_imagen = './assets/tipos/' . strtolower($row["tipo_id"]) . '.webp';
            $tipo2_imagen = './assets/tipos/' . strtolower($row["tipo2_id"]) . '.webp';

            echo '<img class="m-1 imagen-tipo" src="' . $tipo1_imagen . '" alt="' . $row["tipo_id"] . '">';
            echo '<img class="m-1 imagen-tipo" src="' . $tipo2_imagen . '" alt="' . $row["tipo2_id"] . '">';
        } else {
            $tipo1_imagen = './assets/tipos/' . strtolower($row["tipo_id"]) . '.webp';

            echo '<img class="m-1 imagen-tipo" src="' . $tipo1_imagen . '" alt="' . $row["tipo_id"] . '">';
        }
    }
} else {
    echo "No se encontraron Pokémon.";
}

$conexion->close();

?>