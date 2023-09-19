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
    <title>Página de inicio</title>
    <link rel="stylesheet" type="text/css" href="./style/style.css">
    <link href="./assets/favicon.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <img src="./assets/pokdex-logo.png" class="pokelogo" href="home.php">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                if (isset($_SESSION['roleID']) && $_SESSION['roleID'] === 1) {
                    echo '<li class="nav-item">';
                    echo '<button class="btn btn-danger" type="button">Nuevo Pokemon<i class="bi bi-plus" style="margin-left: 5px"></i></button>';
                    echo '</li>';
                }
                ?>
            </ul>
            <form method="post" action="scripts/logOut.php">
                <button class="btn btn-danger" type="submit">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <h2>Bienvenido, <?php echo $usuario; ?></h2>
    <p>Esta es tu página de inicio.</p>

    <h3>Tus Pokémon:</h3>
    <div class="row">
        <?php
        $conexion = new mysqli("localhost", "root", "", "pokedex");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

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
                    $tipo1_imagen = './assets/tipos/' . strtolower($row["tipo_id"]) . '.webp';
                    $tipo2_imagen = './assets/tipos/' . strtolower($row["tipo2_id"]) . '.webp';

                    echo '<img class="m-1 imagen-tipo" src="' . $tipo1_imagen . '" alt="' . $row["tipo_id"] . '">';
                    echo '<img class="m-1 imagen-tipo" src="' . $tipo2_imagen . '" alt="' . $row["tipo2_id"] . '">';
                } else {
                    $tipo1_imagen = './assets/tipos/' . strtolower($row["tipo_id"]) . '.webp';

                    echo '<img class="m-1 imagen-tipo" src="' . $tipo1_imagen . '" alt="' . $row["tipo_id"] . '">';
                }

                echo '<div class="d-flex justify-content-center m-2">';
                echo '<form class="m-1" method="post" action="./scripts/editarPokemon.php">';
                echo '<input type="hidden" name="pokemon_id" value="' . $row["id"] . '">';
                echo '<button type="submit" class="btn btn-primary"><i class="bi bi-pencil"></i></button>';
                echo '</form>';

                echo '<form class="m-1" method="post" action="./scripts/borrarPokemon.php">';
                echo '<input type="hidden" name="pokemon_id" value="' . $row["id"] . '">';
                echo '<button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>';
                echo '</form>';
                echo '</div>';


                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No se encontraron Pokémon.";
        }


        $conexion->close();
        ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
