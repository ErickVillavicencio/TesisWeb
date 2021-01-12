<?php
require_once('../Modelo/usuario.php');
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
}
require_once "../ConeccionBD/conexion.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Administracion de Puntos Turísticos</title>
    <link href="Css/formulario.css" rel="stylesheet" type="text/css" />
    <link href="Css/botonsalir.css" rel="stylesheet" type="text/css" />
    <link href="Css/tabla.css" rel="stylesheet" type="text/css" />
    <link href="Css/mapaInicio.css" rel="stylesheet" type="text/css" />
    <link href="Css/header.css" rel="stylesheet" type="text/css" />
    <link href="Css/footermap.css" rel="stylesheet" type="text/css" />
    <script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />
    <script src="js/jquery-3.5.1.min.js"></script>
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
                        <a href="inicioTurista.php" class="active">Inicio</a>
                        <a href="crearRuta.php">Crear Ruta</a>
                        <a href="rutasTurista.php">Mis rutas</a>
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

    <?php
    $idUsuario = $_SESSION['usuario']->getId();
    ?>


    <div class="contenedor">
        <!-- mapa -->
        <div id="map"></div>
    </div>
    <script>
        var map = L.map('map').

        setView([0.0893651, -78.4055, 14.5],
            13);

        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 20
        }).addTo(map);




        //marcadores
        <?php

        $sql = "SELECT pt.id as id, pt.nombre as nombre, pt.descripcion as descripcion, pt.latitud as latitud,
    pt.longuitud as longuitud, pt.categoriaId as categoriaId, pt.subCategoriaId as subcategoriaId,
    pt.costo AS costo, pt.costoN AS costoN, pt.idParroquia as idParroquia, pt.tiempoEstimado as tiempoEstimado,
    img.id as idImagen, img.nombre as imgnombre, img.direccion as imagen, img.extencion as extencion,
    img.idPuntoTuristico as idPuntoTuristico, img.categoria as imgCategoria, pr.descripcion as parroquian,
    cat.descripcion as catnombre, sub.descripcion as subnombre
    FROM puntoturistico as pt INNER JOIN imagen as img
    on pt.id = img.idPuntoTuristico 
    INNER JOIN parroquia as pr
    ON pt.idParroquia = pr.id
    INNER JOIN categoria AS cat
    ON pt.categoriaId = cat.id
    INNER JOIN subcategoria as sub
    ON sub.id = cat.id
    WHERE img.categoria = 1  AND pt.estado = 1";
        $pdo = Db::conectar();
        if ($result = $pdo->query($sql)) {

            $puntos = array();
            $i = 0;

            while ($row = $result->fetch()) {
                $puntos[$i] = array();
                $puntos[$i]['id'] = $row['id'];
                $puntos[$i]['nombre'] = $row['nombre'];
                $puntos[$i]['latitud'] = $row['latitud'];
                $puntos[$i]['longuitud'] = $row['longuitud'];
                $puntos[$i]['imagen'] = $row['imagen'];
                $puntos[$i]['extencion'] = $row['extencion'];
                $puntos[$i]['parroquian'] = $row['parroquian'];
                $puntos[$i]['descripcion'] = $row['descripcion'];
                $puntos[$i]['catnombre'] = $row['catnombre'];
                $puntos[$i]['subnombre'] = $row['subnombre'];
                $puntos[$i]['tiempoEstimado'] = $row['tiempoEstimado'];
                $puntos[$i]['costo'] = $row['costo'];
                $puntos[$i]['costoN'] = $row['costoN'];
                $i++;
            }
        } else {
            echo "ERROR: No se pudo Ejecutar $sql. " . $mysqli->error;
        }
        unset($pdo);
        ?>


        <?php
        $longitud = count($puntos);
        for ($i = 0; $i < $longitud; $i++) {

            $imagen = $puntos[$i]['imagen'];
            $extencion = $puntos[$i]['extencion'];
            $descripcion = $puntos[$i]['descripcion'];
            $cadena = substr($descripcion, 0, 100);
        ?>




            L.marker([<?php echo ($puntos[$i]['latitud']) ?>, <?php echo ($puntos[$i]['longuitud']) ?>], {
                icon: L.divIcon({
                    html: "<img src='<?php echo $puntos[$i]['imagen']; ?>'>",
                    className: 'image-icon',
                    iconSize: [70, 70]
                })
            }).addTo(map).bindPopup(

                '<div class="tarjeta">' +

                '<div class="titulo">' +
                '<label><?php echo ($puntos[$i]['nombre']) ?></label>' +
                '</div>' +

                '<div class="card">' +
                '<br>' +
                '<div class="contenedorImagen"><img class="imgRedonda" src="<?php echo ($imagen) ?>" /></div>' +

                '<div class="contenedor">' +
                '<p><?php echo ($cadena) ?> <a class="button" href="informacionPunto.php?id=<?php echo ($puntos[$i]['id']) ?>"> ...ver mas.</a> </p>' +
                '<div class="separator"></div>' +
                '<TABLE class="tabla" >' +
                '<TR><TH>Parroquia: </TH>' +
                '<TD><?php echo ($puntos[$i]['parroquian']) ?></TD></TR>' +

                '<TR><TH>Categoria:</TH>' +
                '<TD><?php echo ($puntos[$i]['catnombre']) ?></TD></TR>' +

                '<TR><TH>Subcategoria:</TH>' +
                '<TD><?php echo ($puntos[$i]['subnombre']) ?></TR>' +

                '<TR><TH>Costo Adulto:</TH>' +
                '<TD>$<?php echo ($puntos[$i]['costo']) ?></TR>' +

                '<TR><TH>Costo Niño:</TH>' +
                '<TD>$<?php echo ($puntos[$i]['costoN']) ?></TR>' +

                '<TR><TH>Tiempo:</TH>' +
                '<TD> <?php echo ($puntos[$i]['tiempoEstimado']) ?></TR>' +
                '</TABLE>' +
                '</div>' +

                '<div class="fab"><i class="fa fa-arrow-down fa-3x"> </i></div>' +
                '</div>' +
                '</div>');
        <?php
        }
        ?>
        $('#map').on('click', '.btnguardar', function() {

            var datos = $('#fmrajax').serialize();
            $.ajax({
                type: "POST",
                url: "../Controladores/controladorPuntosRuta.php",
                data: datos,
                success: function(r) {

                    var jsonData = JSON.parse(r);

                    if (jsonData.success == "1") {
                        alert("Agregado a su ruta");
                    }
                    if (jsonData.success == "0") {
                        alert("El punto ya se encuentra agregado a la ruta");
                    }


                }

            });
            return false;

        });
    </script>


    <script>
        var slideIndex = 1;
        showDivs(slideIndex);

        function plusDivs(n) {
            showDivs(slideIndex += n);
        }

        function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("mySlides");
            if (n > x.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = x.length
            }
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
        }
    </script>
    <!-- _________________________________________________ -->
    </table>
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
                <p>Desarrollador Página Web <span>Villavicencio Erick</span></p>
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