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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                if (isset($_SESSION['roleID']) && $_SESSION['roleID'] === 1) {
                    echo '<li class="nav-item">';
                    echo '<button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#nuevoPokemonModal">Nuevo Pokemon<i class="bi bi-plus" style="margin-left: 5px"></i></button>';
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

<?php
$tipos = [
    1 => "Agua", 2 => "Fuego", 3 => "Planta", 4 => "Acero", 5 => "Volador",
    6 => "Hielo", 7 => "Bicho", 8 => "Electrico", 9 => "Normal", 10 => "Roca",
    11 => "Tierra", 12 => "Lucha", 13 => "Hada", 14 => "Psiquico", 15 => "Veneno",
    16 => "Dragon", 17 => "Fantasma", 18 => "Siniestro"
];
?>

<div class="modal fade" id="nuevoPokemonModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Pokemon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="scripts/agregarPokemon.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="text" class="form-control" id="id" name="id" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="altura" class="form-label">Altura (cm)</label>
                        <input type="text" class="form-control" id="altura" name="altura" pattern="[0-9]+(\.[0-9]+)?" required>
                    </div>
                    <div class="mb-3">
                        <label for="peso" class="form-label">Peso (kg)</label>
                        <input type="text" class="form-control" id="peso" name="peso" pattern="[0-9]+(\.[0-9]+)?" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_id" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo_id" name="tipo_id" onchange="actualizarTipo2()" required>
                            <option value="" disabled selected>Selecciona un tipo</option>
                            <?php
                            foreach ($tipos as $tipo) {
                                echo '<option value="' . $tipo . '">' . ucfirst($tipo) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tipo2_id" class="form-label">Tipo 2</label>
                        <select class="form-select" id="tipo2_id" name="tipo2_id">
                            <option value="" disabled selected>Selecciona un tipo</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function actualizarTipo2() {
        const tipo1 = document.getElementById('tipo_id').value;
        const tipo2Select = document.getElementById('tipo2_id');

        tipo2Select.innerHTML = '<option value="" disabled selected>Selecciona un tipo</option>';

        <?php
        foreach ($tipos as $tipo) {
            echo 'if ("' . $tipo . '" !== tipo1) {';
            echo 'tipo2Select.innerHTML += \'<option value="' . $tipo . '">' . ucfirst($tipo) . '</option>\';';
            echo '}';
        }
        ?>
    }

    actualizarTipo2();
</script>

<div class="container">
    <h2>Bienvenido, <?php echo $usuario; ?></h2>
    <p>Esta es tu página de inicio.</p>

    <h3>Tus Pokémon:</h3>

    <form class="form-inline mb-3" method="post" action="./scripts/procesarFiltro.php">
        <h5>Filtrar por:</h5>
        <div class="d-flex align-items-center">
            <div class="form-group mb-2">
                <select class="form-select" name="tipo" id="tipo">
                    <option value="" disabled>Tipo...</option>
                    <?php
                    foreach ($tipos as $numeroReferencia => $tipo) {
                        echo '<option value="' . $numeroReferencia . '">' . ucfirst($tipo) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mx-sm-2 mb-2">
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del Pokémon">
            </div>
            <div class="form-group mb-2">
                <button type="submit" class="btn btn-primary ml-2">Filtrar</button>
            </div>
        </div>
    </form>

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
                echo '<div class="col-lg-4 col-md-12 col-sm-12 mb-4">';
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


                if (isset($_SESSION['roleID']) && $_SESSION['roleID'] === 1) {
                    echo '<div class="d-flex justify-content-center m-2">';
                    echo '<form class="m-1" method="post" action="./editarPokemonIndex.php">';
                    echo '<input type="hidden" name="pokemon_id" value="' . $row["id"] . '">';
                    echo '<a class="btn btn-primary" type="button" href="./editarPokemonIndex.php?id=' . $row['id'] . '"><i class="bi bi-pencil"></i></a>';
                    echo '</form>';

                    echo '<form class="m-1" method="post" action="./scripts/borrarPokemon.php">';
                    echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                    echo '<button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>';
                    echo '</form>';
                    echo '</div>';
                }

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