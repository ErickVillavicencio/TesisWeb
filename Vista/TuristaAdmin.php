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
  <link href="Css/footermap.css" rel="stylesheet" type="text/css" />
  <link href="Css/header.css" rel="stylesheet" type="text/css" />
  <link href="Css/tabla.css" rel="stylesheet" type="text/css" />
  <link href="Css/mapa.css" rel="stylesheet" type="text/css" />
  <link href="Css/filtro.css" rel="stylesheet" type="text/css" />
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
            <a href="inicioTurista.php">Inicio</a>
            <a href="" class="active">Crear Ruta</a>
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

<?php
$sql = "SELECT pt.id as id, pt.nombre as nombre, pt.descripcion as descripcion, pt.latitud as latitud,
    pt.longuitud as longuitud, pt.categoriaId as categoriaId, pt.subCategoriaId as subid,
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
    ON sub.id = pt.subCategoriaId
    WHERE img.categoria = 1 AND pt.estado = 1";
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
    $puntos[$i]['idParroquia'] = $row['idParroquia'];
    $puntos[$i]['descripcion'] = $row['descripcion'];
    $puntos[$i]['catnombre'] = $row['catnombre'];
    $puntos[$i]['categoriaId'] = $row['categoriaId'];
    $puntos[$i]['subnombre'] = $row['subnombre'];
    $puntos[$i]['tiempoEstimado'] = $row['tiempoEstimado'];
    $puntos[$i]['costo'] = $row['costo'];
    $puntos[$i]['costoN'] = $row['costoN'];
    $puntos[$i]['subid'] = $row['subid'];
    $i++;
  }
} else {
  echo "ERROR: No se pudo Ejecutar $sql. " . $mysqli->error;
}
unset($pdo);
?>


<body>


  <?php
  $idUsuario = $_SESSION['usuario']->getId();
  $nombre = $_GET['nombre'];
  ?>

  <?php
  $db = Db::conectar();
  $select = $db->prepare("SELECT id, nombre FROM ruta WHERE idUsuario = '$idUsuario' AND nombre = $nombre ");
  $select->execute();
  while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
    $idruta = $row['id'];
    $nombreRuta = $row['nombre'];
  } ?>

  <div class="titulo">
    <?php
    echo "<b>Ruta:</b>  $nombreRuta ";
    ?>
  </div>

  <div class="filtro">
    <table class="tablafiltro">
      <tr>
        <td rowspan="2">Filtrar por:</td>
        <td>Parroquia</td>
        <td>Categoría</td>
        <td>Subategoría</td>
      </tr>
      <tr>
        <td>
          <form>
            <select name="idParroquia" id="parroquia" class="select">
              <option value="0">Seleccionar Parroquia</option>
              <?php
              $db = Db::conectar();
              $select = $db->prepare('SELECT id, descripcion FROM parroquia WHERE estado = 1');
              $select->execute();
              while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['id'] . '">' . $row['descripcion'] . '</option>';
              }
              unset($pdo);
              ?>
            </select>
        </td>
        <td>
          <select name="categoriaId" id="categoria" class="select">
            <option value="0">Seleccionar Categoría</option>
            <?php
            $db = Db::conectar();
            $select = $db->prepare('SELECT id, descripcion FROM categoria WHERE estado = 1');
            $select->execute();
            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
              echo '<option value="' . $row['id'] . '">' . $row['descripcion'] . '</option>';
            }
            unset($pdo);
            ?>
          </select>
        </td>
        <td>
          <select name="subCategoriaId" id="subcategoria" class="select">
            <option value="0">Seleccione Sub Categoría</option>
          </select>
          </form>
        </td>
        <td><button class="generarbtn" id="filtrarbtn" onclick="filtrar()">Filtrar</button></td>
        <td><button class="generarbtn" onclick="refrescar()">Refrescar</button></td>
      </tr>
    </table>

  </div>




  <!-- mapa -->
  <div id="map"></div>
  <script>
    var map = L.map('map').

    setView([0.0893651, -78.4055, 14.5],
      13);

    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 20
    }).addTo(map);


    var puntos = <?php echo json_encode($puntos); ?>;
    var cad = '';
    var cadena = '';
    var marker = new Array();
    var x;
    for (i = 0; i < puntos.length; i++) {
      cad = puntos[i].descripcion;
      cadena = cad.substr(0, 100);
      var LamMarker = new L.marker([puntos[i].latitud, puntos[i].longuitud], {
        icon: L.divIcon({
          html: '<img src="' + puntos[i].imagen + '">',
          className: 'image-icon',
          iconSize: [70, 70]
        })
      });
      marker.push(LamMarker);
      map.addLayer(marker[i]);
      marker[i].bindPopup(
        '<div class="tarjeta">' +
        '<div class="titulo">' +
        '<label>' + puntos[i].nombre + '</label>' +
        '</div>' +
        '<div class="card">' +
        '<br>' +
        '<div class="contenedorImagen"><img class="imgRedonda" src="' + puntos[i].imagen + '" /></div>' +
        '<div class="contenedor">' +
        '<p>' + cadena + '<a class="button" href="informacionPunto.php?id=' + puntos[i].id + '"> ...ver mas.</a> </p>' +

        '<div class="separator"></div>' +
        '<TABLE class="tabla" >' +
        '<TR><TH>Parroquia: </TH>' +
        '<TD>' + puntos[i].parroquian + '</TD></TR>' +
        '<TR><TH>Categoría:</TH>' +
        '<TD>' + puntos[i].catnombre + '</TD></TR>' +
        '<TR><TH>Subcategoría:</TH>' +
        '<TD>' + puntos[i].subnombre + '</TR>' +
        '<TR><TH>Costo Adulto:</TH>' +
        '<TD>$' + puntos[i].costo + '</TR>' +
        '<TR><TH>Costo Niño:</TH>' +
        '<TD>$' + puntos[i].costoN + '</TR>' +
        '<TR><TH>Tiempo:</TH>' +
        '<TD>' + puntos[i].tiempoEstimado + '</TR>' +
        '</TABLE>' +
        '</div>' +
        '<div class="fab"><i class="fa fa-arrow-down fa-3x"> </i></div>' +
        '</div>' +
        '<form id="fmrajax" method="POST">' +
        '<div>' +
        '<input type="hidden" name="idRuta" id="idRuta" value="<?php echo $idruta; ?>" >' +
        '</div>' +
        '<input type="hidden" name="idPunto" id="idPunto" value="' + puntos[i].id + '">' +
        '<input type="hidden" name="registrar" value="registrar" class="form-control">' +
        '<div class="boton">' +
        '<br>' +
        '<button  id="btnguardar" class="btnguardar" >Agregar</button>' +
        '<br> -' +
        '</div>' +
        '</form>' +
        '</div>');
    }

    function filtrar() {
      for (i = 0; i < puntos.length; i++) {
        map.removeLayer(marker[i]);
      }
      punto = <?php echo json_encode($puntos); ?>;

      //console.log(punto);

      //elimina los puntos de la lista para volver a crearlos
      var parroquia = document.getElementById("parroquia").value;
      var categoria = document.getElementById("categoria").value;
      var subcategoria = document.getElementById("subcategoria").value;

      var lista = new Array();
      var j = 0;
      //recorro el array
      for (i = 0; i < punto.length; i++) {


        if (punto[i].idParroquia == parroquia &&
          (parroquia > 0 && categoria == 0 && subcategoria == 0)) {
          lista.unshift(punto[i]);
        }

        if (punto[i].idParroquia == parroquia && punto[i].categoriaId == categoria &&
          (parroquia > 0 && categoria > 0 && subcategoria == 0)) {
          lista.unshift(punto[i]);
        }

        if (punto[i].idParroquia == parroquia && punto[i].categoriaId == categoria && punto[i].subid == subcategoria &&
          (parroquia > 0 && categoria > 0 && subcategoria > 0)) {
          lista.unshift(punto[i]);
        }

        if (punto[i].categoriaId == categoria && punto[i].subid == subcategoria &&
          (parroquia == 0 && categoria > 0 && subcategoria > 0)) {
          lista.unshift(punto[i]);
        }
      }
      cargar(lista);
      var filtrarbtn = document.getElementById('filtrarbtn');
      filtrarbtn.disabled = true;
    }

    function refrescar() {
      location.reload();
    }


    function cargar(punto) {
      var puntos = punto;
      var cad = '';
      var cadena = '';
      var marker = new Array();
      for (i = 0; i < puntos.length; i++) {
        cad = puntos[i].descripcion;
        cadena = cad.substr(0, 100);
        var LamMarker = new L.marker([puntos[i].latitud, puntos[i].longuitud], {
          icon: L.divIcon({
            html: '<img src="' + puntos[i].imagen + '">',
            className: 'image-icon',
            iconSize: [70, 70]
          })
        });
        marker.push(LamMarker);
        map.addLayer(marker[i]);
        marker[i].bindPopup(
          '<div class="tarjeta">' +
          '<div class="titulo">' +
          '<label>' + puntos[i].nombre + '</label>' +
          '</div>' +
          '<div class="card">' +
          '<br>' +
          '<div class="contenedorImagen"><img class="imgRedonda" src="' + puntos[i].imagen + '" /></div>' +
          '<div class="contenedor">' +
          '<p>' + cadena + '<a class="button" href="informacionPunto.php?id=' + puntos[i].id + '"> ...ver mas.</a> </p>' +
          '<div class="separator"></div>' +
          '<TABLE class="tabla" >' +
          '<TR><TH>Parroquia: </TH>' +
          '<TD>' + puntos[i].parroquian + '</TD></TR>' +
          '<TR><TH>Categoria:</TH>' +
          '<TD>' + puntos[i].catnombre + '</TD></TR>' +
          '<TR><TH>Subcategoria:</TH>' +
          '<TD>' + puntos[i].subnombre + '</TR>' +
          '<TR><TH>Costo Adulto:</TH>' +
          '<TD>$' + puntos[i].costo + '</TR>' +
          '<TR><TH>Costo Niño:</TH>' +
          '<TD>$' + puntos[i].costo + '</TR>' +
          '<TR><TH>Tiempo:</TH>' +
          '<TD>' + puntos[i].tiempoEstimado + '</TR>' +
          '</TABLE>' +
          '</div>' +
          '<div class="fab"><i class="fa fa-arrow-down fa-3x"> </i></div>' +
          '</div>' +
          '<form id="fmrajax" method="POST">' +
          '<div>' +
          '<input type="hidden" name="idRuta" id="idRuta" value="<?php echo $idruta; ?>" >' +
          '</div>' +
          '<input type="hidden" name="idPunto" id="idPunto" value="' + puntos[i].id + '">' +
          '<input type="hidden" name="registrar" value="registrar" class="form-control">' +
          '<div class="boton">' +
          '<br>' +
          '<button  id="btnguardar" class="btnguardar" >Agregar</button>' +
          '<br> -' +
          '</div>' +
          '</form>' +
          '</div>');
      }
    }

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

  <?php
  $sql = "SELECT puntoturistico.id as id,puntoturistico.nombre as nombre, puntoturistico.descripcion as descripcion,
    puntoturistico.latitud as latitud, puntoturistico.longuitud as longuitud,puntoturistico.costo as costo,puntoturistico.costoN as costoN,
     puntoturistico.tiempoEstimado as tiempoEstimado, imagen.nombre as imgnombre, imagen.direccion as imagen ,
     imagen.extencion as extencion,imagen.categoria,parroquia.descripcion as parroquian,categoria.descripcion as catnombre ,
     subcategoria.descripcion as subnombre
    FROM ruta
    INNER JOIN puntosruta
    ON puntosruta.idRuta = ruta.id    
    INNER JOIN puntoturistico 
    ON puntosruta.idPunto = puntoturistico.id 
    INNER JOIN imagen
    ON puntoturistico.id = imagen.idPuntoTuristico
    INNER JOIN parroquia
    ON puntoturistico.idParroquia = parroquia.id
    INNER JOIN categoria
    ON categoria.id = puntoturistico.categoriaId
    INNER JOIN subcategoria
    on subcategoria.id = puntoturistico.subCategoriaId
    WHERE  imagen.categoria = 1 AND ruta.id = $idruta AND puntoturistico.estado = 1";
  $pdo = Db::conectar();
  if ($result = $pdo->query($sql)) {
    $puntosR = array();
    $i = 0;
    while ($row = $result->fetch()) {
      $puntosR[$i] = array();
      $puntosR[$i]['id'] = $row['id'];
      $puntosR[$i]['nombre'] = $row['nombre'];
      $puntosR[$i]['latitud'] = $row['latitud'];
      $puntosR[$i]['longuitud'] = $row['longuitud'];
      $puntosR[$i]['imagen'] = $row['imagen'];
      $puntosR[$i]['extencion'] = $row['extencion'];
      $puntosR[$i]['parroquian'] = $row['parroquian'];
      $puntosR[$i]['descripcion'] = $row['descripcion'];
      $puntosR[$i]['catnombre'] = $row['catnombre'];
      $puntosR[$i]['subnombre'] = $row['subnombre'];
      $puntosR[$i]['tiempoEstimado'] = $row['tiempoEstimado'];
      $puntosR[$i]['costo'] = $row['costo'];
      $puntosR[$i]['costoN'] = $row['costoN'];
      $i++;
    }
  } else {
    echo "ERROR: No se pudo Ejecutar $sql. " . $mysqli->error;
  }
  unset($pdo);
  $longitud = count($puntosR);

  $lat1;
  $lat2;
  $lon1;
  $lon2;
  $ListaDistancia = array();

  //obtengo una lista con la distancia entre puntos en km

  for ($i = 0; $i < $longitud; $i++) {

    $j = $i + 1;

    if ($j < $longitud) {

      $lat1 = $puntosR[$i]['latitud'];
      $lat2 = $puntosR[$j]['latitud'];
      $lon1 = $puntosR[$i]['longuitud'];
      $lon2 = $puntosR[$j]['longuitud'];


      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $distancia = $miles * 1.609344;


      //calcula el tiempo segun la distancia a una velocidad de 
      //si l distancia entre puntos es menor a 2 kimoletros se caminara
      if ($distancia < 2) {
        $velocidad = 5.3; // k/h
        $velocidads = $velocidad * (5 / 18); //transformo k/h a m/s
        $distanciam = $distancia * 1000; //tranformo km a m
        $tiempoD = $distanciam / $velocidads;
        $ListaDistancia[$i] = $tiempoD; //tiempo es s
      } else {
        //si l distancia entre puntos es mayor a 2 kimoletros se usara transporte
        $velocidad = 40;
        $velocidads = $velocidad * (5 / 18); //transformo k/h a m/s
        $distanciam = $distancia * 1000; //tranformo km a m
        $tiempoD = $distanciam / $velocidads;
        $ListaDistancia[$i] = $tiempoD; //tiempo es s
      }
    }
  }
  $tiempoSeg = intval(array_sum($ListaDistancia));
  //convierto los seg a horas min seg
  $horas = floor($tiempoSeg / 3600);
  $minutos = floor(($tiempoSeg - ($horas * 3600)) / 60);
  $segundos = $tiempoSeg - ($horas * 3600) - ($minutos * 60);
  ?>

  <div class="generar">
    <form class="" action="../Controladores/controladorRuta.php" method="post">
      <br>
      <input type="hidden" name="segundos" value="<?php echo $segundos ?>" class="form-control">
      <input type="hidden" name="minutos" value="<?php echo $minutos ?>" class="form-control">
      <input type="hidden" name="horas" value="<?php echo $horas ?>" class="form-control">
      <input type="hidden" name="idRuta" value="<?php echo $idruta ?>" class="form-control">
      <input type="hidden" name="actualizar" value="actualizar" class="form-control">
      <button class="generarbtn">Generar Ruta</button>
    </form>
  </div>



  <!-- Iniciamos el segmento de codigo javascript -->
  <script type="text/javascript">
    $(document).ready(function() {
      var subcategoria = $('#subcategoria');
      var subCategoria_sel = $('#subCategoria_sel');
      $('#categoria').change(function() {
        var subCat_id = $(this).val();
        if (subCat_id !== '') {
          $.ajax({
            data: {
              subCat_id: subCat_id
            }, //variables o parametros a enviar, formato => nombre_de_variable:contenido
            dataType: 'html', //tipo de datos que esperamos de regreso
            type: 'POST', //mandar variables como post o get
            url: '../Controladores/consulta.php' //url que recibe las variables
          }).done(function(data) { //metodo que se ejecuta cuando ajax ha completado su ejecucion             

            subcategoria.html(data); //establecemos el contenido html de discos con la informacion que regresa ajax             
            subcategoria.prop('disabled', false); //habilitar el select
          });
          /*fin de llamada ajax*/
        } else { //en caso de seleccionar una opcion no valida
          subcategoria.val(''); //seleccionar la opcion "- Seleccione -", osea como reiniciar la opcion del select
          subcategoria.prop('disabled', true); //deshabilitar el select
        }
      });
      //mostrar una leyenda con el disco seleccionado
      $('#subcategoria').change(function() {
        $('#subCategoria_sel').html($(this).val() + ' - ' + $('#subcategoria option:selected').text());
      });

    });
  </script>



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