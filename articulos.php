<?php
    include_once 'conexion.php';

    // Obtener número de página
    if (isset($_GET['pag_no']) && $_GET['pag_no'] !== "") {
        $pag_no = $_GET['pag_no'];
    } else {
        $pag_no = 1;
    }

    // Total de filas por página
    $filas_por_pagina = 4;

    // Obtener el desplazamiento de página para el límite de consultas
    $desplazamiento = ($pag_no - 1) * $filas_por_pagina;

    // Obtener la página anterior
    $pagina_anterior = $pag_no - 1;

    // Obtener la página siguiente
    $pagina_siguiente = $pag_no + 1;

    // Obtener el conteo total de resultados
    $conteo_resultados = mysqli_query($conexion, "SELECT COUNT(*) as total_registros FROM taller1.articulos") or die(mysqli_error($conexion));

    // Total de registros
    $registros = mysqli_fetch_array($conteo_resultados);

    // Almacenar el total de registros en una variable
    $total_registros = $registros['total_registros'];

    // Obtener el total de páginas
    $total_paginas = ceil($total_registros / $filas_por_pagina);

    // String de consulta
    $sql = "SELECT * FROM taller1.articulos LIMIT $desplazamiento, $filas_por_pagina";

    // Resultado
    $resultado = mysqli_query($conexion, $sql) or die(mysqli_error($conexion));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <section class="container mt-5">
        <h1>Artículos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio por unidad</th>
                    <th>Unidades disponibles</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = mysqli_fetch_array($resultado)) { ?>
                    <tr>
                        <td><?= $fila['id']; ?></td>
                        <td><?= $fila['nombre']; ?></td>
                        <td><?= $fila['precio']; ?> pesos</td>
                        <td><?= $fila['stock']; ?></td>
                    </tr>
                <?php }
                mysqli_close($conexion)
                ?>
            </tbody>
        </table>

        <!-- Botones de navegación entre páginas -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- Boton para ir a la página anterior -->
                <li class="page-item"><a class="page-link <?= ($pag_no <= 1)? 'disabled' : ''; ?>" <?= ($pag_no > 1)? 'href=?pag_no='.$pagina_anterior : ''; ?>>Anterior</a></li>


                <!-- Botones de posición de página -->
                <?php for ($contador = 1; $contador <= $total_paginas; $contador++) { ?>
                    <?php if ($pag_no != $contador) { ?>
                        <li class="page-item"><a class="page-link" href="?pag_no=<?= $contador; ?>"><?= $contador; ?></a></li>
                    <?php } else { ?>
                        <li class="page-item"><a class="page-link active"><?= $contador; ?></a></li>
                    <?php } ?>
                <?php } ?>

                <!-- Boton para ir a la siguiente página -->
                <li class="page-item"><a class="page-link <?= ($pag_no >= $total_paginas)? 'disabled' : ''; ?>" <?= ($pag_no < $total_paginas)? 'href=?pag_no='.$pagina_siguiente : ''; ?>>Siguiente</a></li>
            </ul>
        </nav>

        <section class="p-10">
            <b>Página <?= $pag_no; ?> de <?= $total_paginas; ?></b>
        </section>

        <a href="index.php">Ir al inicio</a>
    </section>
</body>
</html>