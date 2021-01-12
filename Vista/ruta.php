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
  <title>Administración de Puntos Turísticos </title>
  <link href="Css/formulario.css" rel="stylesheet" type="text/css" />
  <link href="Css/footermap.css" rel="stylesheet" type="text/css" />
  <link href="Css/header.css" rel="stylesheet" type="text/css" />
  <link href="Css/botonsalir.css" rel="stylesheet" type="text/css" />
  <link href="Css/tabla.css" rel="stylesheet" type="text/css" />
  <link href="Css/rutaMapa.css" rel="stylesheet" type="text/css" />
  <link href="Css/informativoPunto.css" rel="stylesheet" type="text/css" />
  <link href="Css/itinerario.css" rel="stylesheet" type="text/css" />
  <script src="js/jquery-3.5.1.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>
  <script src="https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-map.js?key=VideC5xR11dosKXloIOgHpEPPpvMDm6L"></script>
  <script src="https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-routing.js?key=VideC5xR11dosKXloIOgHpEPPpvMDm6L"></script>
</head>



<header id="main-header">
  <a id="logo-header">
    <span class="site-name"> <img src="imagenes\pagina\Logo.png" width="70" height="70"> Generador de Rutas Personalizadas</span>
    <span class="site-desc">Perucho / Chavezpamba / Puéllaro</span>
  </a>
  <div class="header">
    <div class="header-right">
      <a href="inicioTurista.php">Inicio</a>
      <a class="active" href="">Crear Ruta</a>
      <a href="rutasTurista.php">Mis rutas</a>
      <a>
        <form class="form" action="../Controladores/cerrarSesion.php" method="post">
          <input type="hidden" name="salir" value="salir">
          <button class="botonCerrar">Cerrar Sesión</button>
        </form>
      </a></li>
    </div>
  </div>

</header>

<?php
$idUsuario = $_SESSION['usuario']->getId();
$idRuta = $_GET['id'];
//obtener fecha y hora de la ruta
$db = Db::conectar();
$select = $db->prepare("SELECT * FROM ruta WHERE id = $idRuta ");
$select->execute();
while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
  $idruta = $row['id'];
  $nombreRuta = $row['nombre'];
  $fecha = $row['horaInicio'];
  $fechaIF = $row['horaFin'];
  $costo = $row['costoTotal'];
  $nAdultos = $row['numeroAdultos'];
  $nNinio = $row['numeroNinios'];
}

//SEPARO FECHA INICIO
$obj_fecha = date_create_from_format('Y-m-d', $fecha);
$date = date_create($fecha);
$dia = date_format($date, "Y/m/d");
$hora = date_format($date, "H:i:s");
$horax = date_format($date, "H:i");

//SEPARO FECHA FIN
$fechafin = date_create_from_format('Y-m-d', $fechaIF);
$datef = date_create($fechaIF);
$diaf = date_format($datef, "Y/m/d");
$horaf = date_format($datef, "H:i:s");
$horafx = date_format($datef, "H:i");
//____________________________________________//


$sql = "SELECT puntoturistico.id as id, puntosruta.id as idPuntoRuta, puntosruta.idPunto as idPunto, puntosruta.idRuta as idRuta,
puntoturistico.nombre as nombre,puntoturistico.latitud as latitud, puntoturistico.longuitud as longuitud, puntoturistico.tiempoEstimado as tiempoEstimado,
imagen.id as idImagen, imagen.nombre as imagenNombre, imagen.direccion as imagen
FROM puntoturistico
INNER JOIN puntosruta
ON puntoturistico.id = puntosruta.idPunto
INNER JOIN imagen
on puntoturistico.id = imagen.idPuntoTuristico
WHERE puntosruta.idRuta = $idRuta AND imagen.categoria = 1
ORDER BY puntosruta.id ASC";

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
    $puntos[$i]['tiempoEstimado'] = $row['tiempoEstimado'];

    $i++;
  }
} else {
  echo "ERROR: No se pudo Ejecutar $sql. " . $mysqli->error;
}
unset($pdo);
$longitud = count($puntos);
?>


<div class="btnContenedor">
  <a href="editarRuta.php?id=<?php echo $idRuta; ?>" class="btn">Editar</a>
  <a href="inicioTurista.php" class="btn">Cancelar</a>
</div>

<div id="sobreMapa">
  <table>
    <thead>
      <tr>
        <th id="columMapa">Mi Ruta :<?php echo " <b> $nombreRuta </b>"; ?> </th>
        <th>Lista de Puntos</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <div id="map"></div>
        </td>
        <td id="lista">
          <ol class="letras">
            <?php
            for ($i = 0; $i < $longitud; $i++) {
              echo '<li><b><a style="color:black;" href="informacionPunto.php?id=' . $puntos[$i]['id'] . '" >' . $puntos[$i]['nombre'] . '</a></b> </li>';
            }
            ?>
          </ol>

        </td>
      </tr>
    </tbody>
  </table>
</div>


<script type="text/javascript">
  window.onload = function() {
    var map, dir;
    map = L.map('map', {
      layers: MQ.mapLayer(),
      center: [0.0862651, -78.44847],
      zoom: 12,
    });

    dir = MQ.routing.directions();

    //marcadores
    <?php
    $longitud = count($puntos);
    for ($i = 0; $i < $longitud; $i++) {
    ?>
      L.marker([<?php echo ($puntos[$i]['latitud']) ?>, <?php echo ($puntos[$i]['longuitud']) ?>], {
        icon: L.divIcon({
          html: "<img src='<?php echo $puntos[$i]['imagen']; ?>'>",
          className: 'image-icon',
          iconSize: [70, 70]
        })
      }).addTo(map);
    <?php
    }
    ?>
    //establece los puntos
    dir.route({
      locations: [
        <?php
        for ($h = 0; $h < $longitud; $h++) {
        ?> {
            latLng: {
              lat: <?php echo ($puntos[$h]['latitud']) ?>,
              lng: <?php echo ($puntos[$h]['longuitud']) ?>
            }
          },
        <?php
        }
        ?>
      ]
    });
    map.addLayer(MQ.routing.routeLayer({
      directions: dir,
      fitBounds: true
    }));
  }
</script>
</table>
</div>

<div id="informativo">
  <table id="segunda">
    <tr>
      <td>
        <li><b>Fecha Inicio: <?php echo " <b> $dia </b>"; ?></li>
        <li><b>Hora Inicio: <?php echo " <b> $horax </b>"; ?></b></li>
</div>
</td>
<td>
  <li><b>Fecha Fin: <?php echo " <b> $diaf </b>"; ?></li>
  <li><b>Hora Fin: <?php echo " <b> $horafx </b>"; ?></b></li>
</td>
</tr>
<tr>
  <td colspan="2">
    <li><b>Número de Adultos: <?php echo " <b> $nAdultos </b>"; ?></b></li>
    <li><b>Número de Niños: <?php echo " <b>  $nNinio </b>"; ?></b></li>
    <li><b>Costo: <?php echo " <b> $costo </b>"; ?></b></li>
  </td>
</tr>
</table>
</div>

<?php
$longitud = count($puntos);
$lat1;
$lat2;
$lon1;
$lon2;
$ListaDistancia = array();

//obtengo una lista con la distancia entre puntos en km

for ($i = 0; $i < $longitud; $i++) {
  $j = $i + 1;
  if ($j < $longitud) {
    $lat1 = $puntos[$i]['latitud'];
    $lat2 = $puntos[$j]['latitud'];
    $lon1 = $puntos[$i]['longuitud'];
    $lon2 = $puntos[$j]['longuitud'];
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $distancia = $miles * 1.609344;

    //calcula el tiempo segun la distancia a una velocidad de 
    $ListaDistancia[$i]['distancia'] = $distancia;
    $ListaDistancia[$i]['inicio'] = $puntos[$i]['nombre'];
    $ListaDistancia[$i]['fin'] = $puntos[$j]['nombre'];

    //si l distancia entre puntos es menor a 2 kimoletros se caminara
    if ($distancia < 2) {
      $ListaDistancia[$i]['recorrido'] = 'Caminata';
      $velocidad = 5.3; // k/h
      $velocidads = $velocidad * (5 / 18); //transformo k/h a m/s
      $distanciam = $distancia * 1000; //tranformo km a m
      $tiempoD = $distanciam / $velocidads;
      $ListaDistancia[$i]['tiempo'] = $tiempoD;
    } else {
      //si l distancia entre puntos es mayor a 2 kimoletros se usara transporte
      $ListaDistancia[$i]['recorrido'] = 'Transporte';
      $velocidad = 40; //km/h
      $velocidads = $velocidad * (5 / 18); //transformo k/h a m/s
      $distanciam = $distancia * 1000; //tranformo km a m
      $tiempoD = $distanciam / $velocidads;
      $ListaDistancia[$i]['tiempo'] = $tiempoD;
    }
  }
}

?>


<div class="contenedorItinerario">
  <h1>Itinerario</h1>

  <table class="itinerario">

    <tr>
      <td class="informativo" colspan="5">Hora Inicio: <?php echo " <b> $hora </b>"; ?></td>
    </tr>
    <tr class="espacio"></tr>
    <?php
    $horas;
    $minutos;
    $segundos;
    $inicio =  $hora;
    for ($i = 0; $i < $longitud; $i++) {
      //sumo la hora inicio con el tiempo del punto  
      $mifecha2 = new DateTime($puntos[$i]['tiempoEstimado']); //tiempo estimado en formato h:m:s
      $mifecha = new DateTime($inicio); //hora inicio en formato h:m:s
      //sumo las dos horas y obtengo una hora fin
      $mifecha->modify('+' . $mifecha2->format('H') . ' hours');
      $mifecha->modify('+' . $mifecha2->format('i') . ' minute');
      $mifecha->modify('+' . $mifecha2->format('s') . 'second');
      $fin = $mifecha->format('H:i:s');
      echo ('  
    <tr>
    <td class="fila">Punto' . ($i + 1) . ' :' . $puntos[$i]['nombre'] . '</td>
    <td class="fila">Tiempo de recorrido(HH/mm/ss): ' . $puntos[$i]['tiempoEstimado'] . '</td>
    <td class="fila">Inicio: ' . $inicio . '</td>
    <td class="fila">Fin: ' . $fin . '</td>
    </tr>  
    <tr class="espacio"></tr>
  ');
      if ($i < ($longitud - 1)) {
        $tiempoSeg = intval($ListaDistancia[$i]['tiempo']);
        $horas = floor($tiempoSeg / 3600);
        $minutos = floor(($tiempoSeg - ($horas * 3600)) / 60);
        $segundos = $tiempoSeg - ($horas * 3600) - ($minutos * 60);
        echo ('  
  <tr>
<td class="informativo">' . $ListaDistancia[$i]['inicio'] . ' - ' . $ListaDistancia[$i]['fin'] . ' </td>
<td class="informativo">
Tiempo de recorrido:
<ul>
<li type="none">' . $horas . ' Horas </li>
<li type="none">' . $minutos . ' Minutos</li>
<li type="none">' . $segundos . ' Segundos</li>
</ul>
</td>
<td class="informativo">Tipo Recorrido:' . $ListaDistancia[$i]['recorrido'] . '</td>');

        if (intval(($ListaDistancia[$i]['distancia'] * 1000)) < 1000) {
          echo ('<td class="informativo">Distancia: ' . intval(($ListaDistancia[$i]['distancia'] * 1000)) . ' m</td>
  ');
        } else {
          echo ('<td class="informativo">Distancia: ' . round($ListaDistancia[$i]['distancia'], 3) . ' Km</td>
  ');
        }

        echo ('
  </tr>
  <tr class="espacio"></tr>');

        //sumo la hora fin con el tiempo de punto a punto
        $mifecha->modify('+' . $horas . ' hours');
        $mifecha->modify('+' . $minutos . ' minute');
        $mifecha->modify('+' . $segundos . 'second');
        $inicio = $mifecha->format(' H:i:s');
      }
    }
    ?>
    <tr>
      <td class="informativo" colspan="5">Fin:<?php echo " <b> $horaf </b>"; ?></td>
    </tr>
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

</html>