<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Administracion de Puntos Turísticos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link href="Css/formulario.css" rel="stylesheet" type="text/css" />
    <link href="Css/footer.css" rel="stylesheet" type="text/css" />
    <link href="Css/header.css" rel="stylesheet" type="text/css" />
    <link href="Css/paginator.css" rel="stylesheet" type="text/css" />
    <link href="Css/botonsalir.css" rel="stylesheet" type="text/css" />
    <link href="Css/tabla.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>

<header id="main-header">
    <table style="width: 100%;">
        <tr>
            <td>
                <a id="logo-header">
                    <span class="site-name"> <img src="imagenes\pagina\Logo.png" width="70" height="70"> Generador de Rutas Personalizadas</span>
                    <span class="site-desc">Perucho / Chavezpamba / Puéllaro</span>
                </a>
            </td>
            <td style="margin-right: 0px;">
                <div class="header">
                    <div class="header-right">
                    <a href="ParroquiasAdmin.php">Parroquias</a>
            <a href="categoriasAdmin.php">Categorías</a>
            <a href="subCategoriasAdmin.php">Sub Categorías</a>
            <a class="active" href="PuntosAdmin.php">Puntos Turísticos </a>
                        <a>
                            <form class="form" action="../Controladores/cerrarSesion.php" method="post">
                                <input type="hidden" name="salir" value="salir">
                                <button class="botonCerrar">Cerrar Sesión</button>
                            </form>
                        </a></li>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</header>
<body>


    <div class="tablaborde">
        <br>
        <div class="col-md-12">
            <h2 class="pull-left">Puntos Turísticos</h2>
            <a href="crearPuntoTuristico.php" class="btn btn-success pull-right">Agregar nuevo Punto Turístico</a>
        </div>

        <table class='container'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Latitud</th>
                    <th>Longuitud</th>
                    <th>Categorías</th>
                    <th>Sub Categorías</th>
                    <th>Costo Adulto</th>
                    <th>Costo Niño</th>
                    <th>Parroquia</th>
                    <th>Tiempo Estimado</th>
                    <th>Estado</th>
                    <th>Imagenes</th>
                    <th>Acción</th>
                </tr>
                <?php
                require_once "../ConeccionBD/conexion.php";


                //consulta para el paginador
                $dbs = Db::conectar();
                $select = $dbs->prepare('SELECT COUNT(*) as totalRegistros From puntoturistico');
                $select->execute();
                $resultado = $select->fetch();
                $total_registro = $resultado['totalRegistros'];
                $por_pagina = 15; 
                if (empty($_GET['pagina'])) {
                    $pagina = 1;
                } else {
                    $pagina = $_GET['pagina'];
                }
                $desde = ($pagina - 1) * $por_pagina;
                $total_paginas = ceil($total_registro / $por_pagina);
                unset($dbs);

                $sql = "SELECT pt.id as id, pt.nombre as nombre, pt.descripcion 
                    as descripcion, pt.latitud as latitud, pt.longuitud as longuitud, 
                    pt.creador as creador,  pt.costo as costo,  pt.costoN as costoN, pt.tiempoEstimado 
                    as tiempoEstimado, pt.estado as estado, cat.descripcion as 
                    idCategoria, sub.descripcion as subCategoriaId, pa.descripcion
                    as idParroquia FROM puntoturistico as pt  INNER JOIN categoria as cat
                    ON pt.categoriaId = cat.id INNER JOIN subcategoria as sub
                    ON pt.subCategoriaId = sub.id INNER JOIN parroquia as pa
                    ON pt.idParroquia = pa.id
                    ORDER BY estado DESC, id ASC  LIMIT $desde,$por_pagina";
                $pdo = Db::conectar();
                if ($result = $pdo->query($sql)) {
                    if ($result->rowCount() > 0) {

                        while ($row = $result->fetch()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['nombre'] . "</td>";
                            echo "<td>" . $row['latitud'] . "</td>";
                            echo "<td>" . $row['longuitud'] . "</td>";
                            echo "<td>" . $row['idCategoria'] . "</td>";
                            echo "<td>" . $row['subCategoriaId'] . "</td>";
                            echo "<td>" . $row['costo'] . "</td>";
                            echo "<td>" . $row['costoN'] . "</td>";
                            echo "<td>" . $row['idParroquia'] . "</td>";
                            echo "<td>" . $row['tiempoEstimado'] . "</td>";
                            echo "<td>";
                            if ($row['estado'] == 1) {
                                echo  "Activo";
                            } else {
                                echo  "Eliminado";
                            }
                            "</td>";
                            echo "<td><a href='imagenesAdmin.php?id=" . $row['id'] . "'>Administrar Imagenes</a></td>";
                            echo "<td>";
                            if ($row['estado'] == 1) {
                                echo "<a href='actualizarPuntoTuristico.php?id=" . $row['id'] . "' title='Actualizar Punto Turistico' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>&nbsp;";
                                echo "<a href='eliminarPuntoTuristico.php?id=" . $row['id'] . "' title='Eliminar Punto Turistico' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>&nbsp;";
                                echo "<a href='informacionPunto.php?id=" . $row['id'] . "' title='Ver Punto Turistico' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>&nbsp;";
                            } else {
                                echo "<a href='activarPuntoTuristico.php?id=" . $row['id'] . "' title='Activar Punto Turistico ' data-toggle='tooltip'><span class='glyphicon glyphicon-ok'></span></a>";
                                echo "<a href='informacionPunto.php?id=" . $row['id'] . "' title='Ver Punto Turistico' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>&nbsp;";
                            }
                            echo "</tr>";
                        }
                        unset($result);
                    } else {
                        echo "<p class='lead'><em>No se encontraron resultados.</em></p>";
                    }
                } else {
                    echo "ERROR: No se pudo Ejecutar $sql. " . $mysqli->error;
                }
                unset($pdo);
                ?>

        </table>
    </div>
    </div>
    <div class="paginator">
        <ul>
            <?php
            if ($pagina != 1) {
            ?>
                <li><a href="?pagina=<?php echo 1; ?>">|<<</a> </li> <li><a href="?pagina=<?php echo $pagina - 1; ?>">
                                <<</a> </li> <?php
                                            }
                                            for ($i = 1; $i <= $total_paginas; $i++) {
                                                if ($i == $pagina) {
                                                    echo '<li class="pageSelected">' . $i . '</li>';
                                                } else {
                                                    echo '<li><a href="?pagina=' . $i . '">' . $i . '</a></li>';
                                                }
                                            }
                                            if ($pagina != $total_paginas) {
                                                ?> <li><a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
                <li><a href="?pagina=<?php echo $total_paginas ?>">>>|</a></li>
            <?php
                                            }
            ?>
        </ul>
    </div>

    <footer class="footer-distributed">
        <div class="footer-left">
            <img src="imagenes\pagina\Logo.png" width="100" height="100">
            <h4>Generador de Rutas Personalizadas</h4>
            <p class="footer-links">
                <a href="#">Perucho</a>
                <a href="#">Puéllaro</a>
                <a href="#">Chavezpamba</a>
                <a></a>
            </p>
        </div>
        <div class="footer-center">
            <div>
                <i class="fa fa-map-marker"></i>
                <p>Autores:</p>
            </div>
            <br>
            <div>
                <i class="fa fa-phone"></i>
                <p>Desarrollador Página Web: <span>Villavicencio Erick</span></p>
            </div>
            <br>
            <div>
                <i class="fa fa-envelope"></i>
                <p> Condensador de información:<span>Tipán Katherine</span></p>
            </div>
            <div>
                <i class="fa fa-map-marker"></i>
                <p>Instituciones:</p>
                <br>
                <div>
                    <a href="http://yavirac.edu.ec/" target="_blank"><img src="imagenes\pagina\ITSBJ.png" width="125" height="90"></a>
                    &nbsp&nbsp
                    <a href="http://yavirac.edu.ec/" target="_blank"><img src="imagenes\pagina\ITSYAVIRAC.png" width="125" height="100"></a>
                </div>
            </div>
        </div>
        <div class="footer-right">
            <p class="footer-company-about">
                <span>Colaboración:</span>
                Orlando Silva
                <br>
                María Almeida
                <br>
                Carmen Moreno
                <br>
                William Vaca
                <br>
                GAD Perucho | GAD Chavezpamba | GAD Puéllaro
            </p>
            <div>
                <a href="#"><img src="imagenes\pagina\GADPERUCHO.png" width="75" height="75"></a>
                <a href="#"><img src="imagenes\pagina\GADCHAVEZPAMBA.jpg" width="75" height="75"></a>
                <a href="#"><img src="imagenes\pagina\GADPUELLARO.jpg" width="75" height="75"></a>
            </div>
        </div>
    </footer>
</body>

</html>