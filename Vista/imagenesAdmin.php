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
    <link href="Css/botonsalir.css" rel="stylesheet" type="text/css" />
    <link href="Css/tabla.css" rel="stylesheet" type="text/css" />
    <link href="Css/popUpCambiarImagen.css" rel="stylesheet" type="text/css" />
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
            <a class="active" href="PuntosAdmin.php">Puntos Turísticos</a>
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

        <table class='container'>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Extencion</th>
                <th>Punto Turístico</th>
                <th>Categoria</th>
                <th>Acción</th>
            </tr>

            <?php
            require_once "../ConeccionBD/conexion.php";
            $id = $_GET['id'];
            $sql = "SELECT  img.id as id, img.nombre as nombre, img.direccion as imagen, 
                    img.extencion as extencion, img.categoria as categoria, pt.nombre as nombrept, pt.id as idpt 
                    FROM imagen as img INNER JOIN puntoturistico as pt
                    ON img.idPuntoTuristico = pt.id 
                    WHERE img.idPuntoTuristico= $id ";
            $pdo = Db::conectar();
            if ($result = $pdo->query($sql)) {
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo '<td><img  class="imagen" src="' . $row['imagen'] . ' "/> </td>';
                        echo "<td>" . $row['extencion'] . "</td>";
                        echo "<td>" . $row['nombrept'] . "</td>";
                        if ($row['categoria'] == 1) {
                            echo "<td> Portada </td>";
                        } else {
                            echo "<td> Otras </td>";
                        }
                        echo "<td>
                                <a class='button' href='cambiarImagen.php?id=" . $row['id'] .
                            "&idpt=" . $row['idpt'] .
                            "&cat=" . $row['categoria'] .
                            "&d=" . $row['imagen'] . "'>Cambiar Imagen</a></td>                          
                             </td>";
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
    <div class="separador">
        __________________________________________________________________________________________________
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