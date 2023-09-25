<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location: login.php");
}

$usuario = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>¿Quien es este pokemon?</title>
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link href="../assets/favicon.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <img src="../assets/pokdex-logo.png" class="pokelogo" alt="">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                if (isset($_SESSION['roleID']) && $_SESSION['roleID'] === 1) {
                    echo '<li class="nav-item">';
                    echo '<button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#nuevoPokemonModal">Nuevo Pokemon<i class="bi bi-plus" style="margin-left: 5px"></i></button>';
                    echo '</li>';
                }
                ?>
            </ul>
            <form method="post" action="./logOut.php">
                <button class="btn btn-danger" type="submit">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</nav>

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
    echo '<div class="container">';
    echo '<a class="btn btn-danger mt-2" href="../home.php"><i class="bi bi-arrow-left m-2"></i> Volver</a>';
    echo '<div class="row row-cols-1 row-cols-md-3 g-4 mt-1">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-lg-4 col-md-12 col-sm-12 mb-4">';
        echo '<div class="card text-center">';
        echo '<div class="card-body">';

        // Encabezado con el nombre del Pokémon
        echo '<h5 class="card-title">' . $row["nombre"] . '</h5>';

        // Imagen del Pokémon
        echo '<img src="data:image/jpeg;base64,' . base64_encode($row["imagen"]) . '" class="imagen-pokemon mx-auto" alt="' . $row["nombre"] . '">';

        // Detalles del Pokémon
        echo '<div class="pokemon-details">';

        // Información del Pokémon (Nro, Altura, Peso)
        echo '<div class="pokemon-info">';
        echo '<p class="card-text">Nro: ' . $row["id"] . '</p>';
        echo '<p class="card-text">Altura: ' . $row["altura"] . ' cm</p>';
        echo '<p class="card-text">Peso: ' . $row["peso"] . ' kg</p>';
        echo '</div>';

        // Tipos del Pokémon
        echo '<div class="pokemon-info">';
        echo '<p class="card-text">Tipo:</p>';

        if (!empty($row["tipo2_id"])) {
            $tipo1_imagen = '../assets/tipos/' . $row["tipo_id"] . '.webp';
            $tipo2_imagen = '../assets/tipos/' . $row["tipo2_id"] . '.webp';

            echo '<img class="m-1 imagen-tipo" src="' . $tipo1_imagen . '" alt="' . $row["tipo_id"] . '">';
            echo '<img class="m-1 imagen-tipo" src="' . $tipo2_imagen . '" alt="' . $row["tipo2_id"] . '">';
        } else {
            $tipo1_imagen = '../assets/tipos/' . $row["tipo_id"] . '.webp';

            echo '<img class="m-1 imagen-tipo" src="' . $tipo1_imagen . '" alt="' . $row["tipo_id"] . '">';
        }
        echo '</div>';
        echo '</div>'; // Fin de pokemon-details

        echo '</div>';
        if (isset($_SESSION['roleID']) && $_SESSION['roleID'] === 1) {
            echo '<div class="d-flex justify-content-center m-2">';
            echo '<form class="m-1" method="post" action="./editarPokemon.php">';
            echo '<input type="hidden" name="pokemon_id" value="' . $row["id"] . '">';
            echo '<a class="btn btn-primary" type="button" href="../editarPokemonIndex.php?id=' . $row['id'] . '"><i class="bi bi-pencil"></i></a>';
            echo '</form>';

            echo '<form class="m-1" method="post" action="./borrarPokemon.php">';
            echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
            echo '<button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>';
            echo '</form>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    // No se encontraron Pokémon, mostrar mensaje de error
    echo '<div class="container">';
    echo '<a class="btn btn-danger mt-2" href="../home.php">Volver</a>';
    echo '<div class="alert alert-danger mt-2" role="alert">Pokemon no encontrado.</div>';
    echo '<div class="row">';

        $sql = "SELECT * FROM pokemon";
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
                    $tipo1_imagen = '../assets/tipos/' . strtolower($row["tipo_id"]) . '.webp';
                    $tipo2_imagen = '../assets/tipos/' . strtolower($row["tipo2_id"]) . '.webp';

                    echo '<img class="m-1 imagen-tipo" src="' . $tipo1_imagen . '" alt="' . $row["tipo_id"] . '">';
                    echo '<img class="m-1 imagen-tipo" src="' . $tipo2_imagen . '" alt="' . $row["tipo2_id"] . '">';
                } else {
                    $tipo1_imagen = '../assets/tipos/' . strtolower($row["tipo_id"]) . '.webp';

                    echo '<img class="m-1 imagen-tipo" src="' . $tipo1_imagen . '" alt="' . $row["tipo_id"] . '">';
                }


                if (isset($_SESSION['roleID']) && $_SESSION['roleID'] === 1) {
                    echo '<div class="d-flex justify-content-center m-2">';
                    echo '<form class="m-1" method="post" action="./editarPokemon.php">';
                    echo '<input type="hidden" name="pokemon_id" value="' . $row["id"] . '">';
                    echo '<a class="btn btn-primary" type="button" href="../editarPokemonIndex.php?id=' . $row['id'] . '"><i class="bi bi-pencil"></i></a>';
                    echo '</form>';

                    echo '<form class="m-1" method="post" action="./borrarPokemon.php">';
                    echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                    echo '<button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>';
                    echo '</form>';
                    echo '</div>';
                }

                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
    echo '</div>';
}

$conexion->close();
?>
