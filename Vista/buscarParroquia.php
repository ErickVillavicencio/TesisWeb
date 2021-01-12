<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Administracion de Parroquias</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link href="Css/formulario.css" rel="stylesheet" type="text/css" />
    <link href="Css/footer.css" rel="stylesheet" type="text/css" />
    <link href="Css/header.css" rel="stylesheet" type="text/css" />
    <link href="Css/botonsalir.css" rel="stylesheet" type="text/css" />
    <link href="Css/tabla.css" rel="stylesheet" type="text/css" />
    <link href="Css/buscador.css" rel="stylesheet" type="text/css" />
    <link href="Css/paginator.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<header id="main-header">
    <a id="logo-header" href="#">
        <span class="site-name">Ruta Escondida</span>
        <span class="site-desc">Perucho / Puellaro / Chavezpamba</span>
    </a>
    <div class="header">
        <div class="header-right">
            <a class="active" href="ParroquiasAdmin.php">Parroquias</a>
            <a href="categoriasAdmin.php">Categorias</a>
            <a href="subCategoriasAdmin.php">Sub Categorias</a>
            <a href="PuntosAdmin.php">Puntos Turisticos</a>
            <a>
                <form class="form" action="../Controladores/cerrarSesion.php" method="post">
                    <input type="hidden" name="salir" value="salir">
                    <button class="botonCerrar">Cerrar Sesión</button>
                </form>
            </a></li>
        </div>
    </div>
</header>

<body>

    <div class="tablaborde">
        <br>
        <div class="col-md-12">
            <h2 class="pull-left">Parroquias</h2>
            <a href="crearParroquia.php" class="btn btn-success pull-right">Agregar nueva Parroquia</a>
        </div>

        <?php
        $busqueda = strtolower($_REQUEST['busqueda']);
        if (empty($busqueda)) {
            header("location: ParroquiasAdmin.php");
        }
        ?>

        <form action="buscarParroquia.php" method="get" class="form_search">
            <input type="text" name="busqueda" id="busqueda" placeholder="buscar" value="<?php echo $busqueda; ?>">
            <input type="submit" value="Buscar" class="btn_search">
        </form>

        <?php
        require_once "../ConeccionBD/conexion.php";
        //consulta para el paginador
        $dbs = Db::conectar();
        $select = $dbs->prepare("Select COUNT(*) as totalRegistros From parroquia WHERE descripcion LIKE '%$busqueda%'");
        $select->execute();
        $resultado = $select->fetch();
        $total_registro = $resultado['totalRegistros'];
        $por_pagina = 5;
        if (empty($_GET['pagina'])) {
            $pagina = 1;
        } else {
            $pagina = $_GET['pagina'];
        }
        $desde = ($pagina - 1) * $por_pagina;
        $total_paginas = ceil($total_registro / $por_pagina);
        $dbs = Db::conectar();
        $sql = "SELECT * FROM parroquia 
WHERE descripcion LIKE '%$busqueda%'
ORDER BY estado DESC
LIMIT $desde,$por_pagina";
        $pdo = Db::conectar();
        if ($result = $pdo->query($sql)) {
            if ($result->rowCount() > 0) {
                echo "<table class='container'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>#</th>";
                echo "<th>Descripción</th>";
                echo "<th>Latitud</th>";
                echo "<th>Longuitud</th>";
                echo "<th>Estado</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $result->fetch()) {

                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['descripcion'] . "</td>";
                    echo "<td>" . $row['latitud'] . "</td>";
                    echo "<td>" . $row['longuitud'] . "</td>";
                    echo "<td>";
                    if ($row['estado'] == 1) {
                        echo  "Activo";
                    } else {
                        echo  "Eliminado";
                    }
                    "</td>";
                    echo "<td>";
                    if ($row['estado'] == 1) {
                        echo "<a href='actualizarParroquia.php?id=" . $row['id'] . "' title='Actualizar Parroquia' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a> &nbsp;";
                        echo "<a href='eliminarParroquia.php?id=" . $row['id'] . "' title='Eliminar Parroquia' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a> &nbsp;";
                    } else {
                        echo "<a href='activarParroquia.php?id=" . $row['id'] . "' title='Activar Parroquia ' data-toggle='tooltip'><span class='glyphicon glyphicon-ok'></span></a>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                unset($result);
            } else {
                echo "<p class='lead'><em>No se encontraron resultados.</em></p>";
            }
        } else {
            echo "ERROR: No se pudo Ejecutar $sql. " . $mysqli->error;
        }
        unset($pdo);
        ?>
    </div>
    </div>
    </div>
    </div>
    </tbody>
    </table>

    <div class="paginator">
        <ul>
            <?php
            if ($pagina != 1) {
            ?>
                <li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<<</a> </li> <li><a href="?pagina=<?php echo $pagina - 1; ?>&busqueda=<?php echo $busqueda; ?>">
                                <<</a> </li> <?php
                                            }
                                            for ($i = 1; $i <= $total_paginas; $i++) {
                                                if ($i == $pagina) {
                                                    echo '<li class="pageSelected">' . $i . '</li>';
                                                } else {
                                                    echo '<li><a href="?pagina=' . $i . '&busqueda=' . $busqueda . '">' . $i . '</a></li>';
                                                }
                                            }
                                            if ($pagina != $total_paginas) {
                                                ?> <li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
                <li><a href="?pagina=<?php echo $total_paginas ?>&busqueda=<?php echo $busqueda; ?>">>>|</a></li>
            <?php
                                            }
            ?>
        </ul>
    </div>
    </div>

    <footer>
        <p>Company © Ruta Escondida. All rights reserved.</p>
    </footer>

</body>

</html>