<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Administracion de Usuarios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link href="Css/formulario.css" rel="stylesheet" type="text/css" />
    <link href="Css/footer.css" rel="stylesheet" type="text/css" />
    <link href="Css/header.css" rel="stylesheet" type="text/css" />
    <link href="Css/botonsalir.css" rel="stylesheet" type="text/css" />
    <link href="Css/tabla.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
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
            <a href="RolesAdmin.php">Roles</a>
            <a class="active" href="UsuariosAdmin.php">Usuarios</a>
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
            <h2 class="pull-left">Usuarios</h2>
            <a href="crearUser.php" class="btn btn-success pull-right">Agregar nuevo usuario</a>
        </div>

        <?php
        require_once "../ConeccionBD/conexion.php";
        $sql = "SELECT * FROM usuario ORDER BY estado DESC";
        $pdo = Db::conectar();
        if ($result = $pdo->query($sql)) {
            if ($result->rowCount() > 0) {
                echo "<table class='container'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>#</th>";
                echo "<th>Nombres</th>";
                echo "<th>Apellidos</th>";
                echo "<th>Usuario</th>";
                echo "<th>Rol</th>";
                echo "<th>Estado</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $result->fetch()) {

                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nombres'] . "</td>";
                    echo "<td>" . $row['apellidos'] . "</td>";
                    echo "<td>" . $row['usuario'] . "</td>";
                    echo "<td>" . $row['idRol'] . "</td>";
                    echo "<td>";
                    if ($row['estado'] == 1) {
                        echo  "Activo";
                    } else {
                        echo  "Eliminado";
                    }
                    "</td>";
                    echo "<td>";
                    if ($row['estado'] == 1) {
                        echo "<a href='actualizarUser.php?id=" . $row['id'] . "' title='Actualizar Usuario' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>  &nbsp;";
                        echo "<a href='eliminarUser.php?id=" . $row['id'] . "' title='Eliminar Usuario'  data-toggle='tooltip'><span class='glyphicon glyphicon-remove'></span></a> &nbsp;";
                    } else {
                        echo "<a href='activarUser.php?id=" . $row['id'] . "' title='Activar Usuario' data-toggle='tooltip'><span class='glyphicon glyphicon-ok'></span></a>";
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