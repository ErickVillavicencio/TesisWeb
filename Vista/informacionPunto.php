<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
}
require_once "../ConeccionBD/conexion.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Administracion de Puntos Turisticos</title>
    <link href="Css/header.css" rel="stylesheet" type="text/css" />
    <link href="Css/footer.css" rel="stylesheet" type="text/css" />
    <link href="Css/redes.css" rel="stylesheet" type="text/css" />
    <link href="Css/informativoPunto.css" rel="stylesheet" type="text/css" />
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

                    <div class="conten">

                        <div class="container--head">
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">



                                    <?php
                                    $id = $_GET['id'];
                                    $db = Db::conectar();
                                    $select = $db->prepare("SELECT  img.id as id, img.nombre as nombre, img.direccion as imagen, 
                                    img.extencion as extencion, img.categoria as categoria, pt.nombre as nombrept, pt.id as idpt 
                                    FROM imagen as img INNER JOIN puntoturistico as pt
                                    ON img.idPuntoTuristico = pt.id 
                                    WHERE img.idPuntoTuristico= $id");

                                    $select->execute();
                                    $puntos = array();
                                    $i = 0;
                                    while ($row = $select->fetch()) {

                                        $puntos[$i] = array();
                                        $puntos[$i]['id'] = $row['id'];
                                        $puntos[$i]['imagen'] = $row['imagen'];
                                        $puntos[$i]['extencion'] = $row['extencion'];
                                        $i++;
                                    }
                                    unset($pdo);
                                    $longitud = count($puntos);
                                    for ($i = 0; $i < $longitud; $i++) {
                                        if ($i == 0) {
                                            echo ' 
                                <div class="item active">
                                <img  class="imagen" src="' . $puntos[$i]['imagen'] . '" alt="..." style="width:100%">
                                 </div> ';
                                        }
                                        if ($i == 1) {
                                            echo '  
                              <div class="item">
                              <img class="imagen" src="' . $puntos[$i]['imagen'] . '" alt="..." style="width:100%">
                                </div>';
                                        }
                                        if ($i == 2) {
                                            echo '  <div class="item">
                                            <img class="imagen" src="' . $puntos[$i]['imagen'] . '" alt="..." style="width:100%">
                                            </div>';
                                        }
                                    }
                                    ?>

                                </div>

                            </div>
                        </div>
                        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
                        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                        <!-- Include all compiled plugins (below), or include individual files as needed -->
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

                    </div>


                </div>
            </div>
        </div>
    </div>




    <?php

    $sql = "SELECT pt.id as id, pt.nombre as nombre, pt.descripcion as descripcion, pt.latitud as latitud,
pt.longuitud as longuitud, pt.categoriaId as categoriaId, pt.subCategoriaId as subcategoriaId,
pt.costo AS costo,pt.costoN AS costoN, pt.idParroquia as idParroquia, pt.tiempoEstimado as tiempoEstimado,
pr.descripcion as parroquian, pt.facebook as facebook, pt.twitter as twitter, pt.instagram as instagram,
cat.descripcion as catnombre, sub.descripcion as subnombre
FROM puntoturistico as pt 
INNER JOIN parroquia as pr
ON pt.idParroquia = pr.id
INNER JOIN categoria AS cat
ON pt.categoriaId = cat.id
INNER JOIN subcategoria as sub
ON sub.id = cat.id
WHERE pt.id = $id";
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
            $puntos[$i]['parroquian'] = $row['parroquian'];
            $puntos[$i]['descripcion'] = $row['descripcion'];
            $puntos[$i]['catnombre'] = $row['catnombre'];
            $puntos[$i]['subnombre'] = $row['subnombre'];
            $puntos[$i]['tiempoEstimado'] = $row['tiempoEstimado'];
            $puntos[$i]['costo'] = $row['costo'];
            $puntos[$i]['costoN'] = $row['costoN'];
            $puntos[$i]['facebook'] = $row['facebook'];
            $puntos[$i]['twitter'] = $row['twitter'];
            $puntos[$i]['instagram'] = $row['instagram'];
        
            $i++;
        }
    } else {
        echo "ERROR: No se pudo Ejecutar $sql. " . $mysqli->error;
    }
    unset($pdo);

    $longitud = count($puntos);
    for ($i = 0; $i < $longitud; $i++) {
    ?>


        <div class="caja"> <?php echo ($puntos[$i]['nombre']) ?> </div>

        <div class="texto">

            <div class="izquierda">
                <p><b> Latitud:</b> <?php echo ($puntos[$i]['latitud']) ?></p>
                <p><b> Longuitud:</b> <?php echo ($puntos[$i]['longuitud']) ?></p>
                <p><b> Categoría:</b> <?php echo ($puntos[$i]['catnombre']) ?></p>
                <p><b> SubCategoría:</b> <?php echo ($puntos[$i]['subnombre']) ?></p>
                <p><b> Costo Adulto:</b> $<?php echo ($puntos[$i]['costo']) ?></p>
                <p><b> Costo Niño:</b> $<?php echo ($puntos[$i]['costoN']) ?></p>
                <p><b> Parroquia:</b> <?php echo ($puntos[$i]['parroquian']) ?></p>
                <p><b> Tiempo de Recorrido:</b> <?php echo ($puntos[$i]['tiempoEstimado']) ?></p>
            </div>

            <div class="derecha">
                <p> <b>Descripción:</b> </p>
                <br>
                <p> <?php echo ($puntos[$i]['descripcion']) ?></p>
          
            </div>

        </div>
        </div>




        <div class="social">
		<ul>
            <?php 
            if (empty($puntos[$i]['facebook'])) {

            }else{
                echo("<li><a href=".$puntos[$i]['facebook']." target='_blank' class='icon-facebook'><img src='https://img.icons8.com/android/50/000000/facebook.png'/></a></li>");
            }   
            if(empty($puntos[$i]['twitter'])) {
            }else{
                echo("<li><a href=".$puntos[$i]['twitter']." target='_blank' class='icon-twitter'><img src='https://img.icons8.com/ios-filled/50/000000/twitter-squared.png'/></a></li>");
            }  
            if(empty($puntos[$i]['instagram'])) {
            }else{
                echo("<li><a href=".$puntos[$i]['instagram']." target='_blank' class='icon-instagram'><img src='https://img.icons8.com/ios-filled/50/000000/instagram-new.png'/></a></li>");
            }      
            ?>
		</ul>
	</div>

    <?php } ?>

<div class="separador">
    <br>
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