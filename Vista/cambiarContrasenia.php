
<?php
require_once "../ConeccionBD/conexion.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Crear Rol</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link href="Css/formulario.css" rel="stylesheet" type="text/css" />
    <link href="Css/footer.css" rel="stylesheet" type="text/css" />
    <link href="Css/header.css" rel="stylesheet" type="text/css" />
    <link href="Css/botonsalir.css" rel="stylesheet" type="text/css" />
    <link href="Css/tabla.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>


<script>
    function soloLetras(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = [8, 37, 39, 46];

        tecla_especial = false
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        if (letras.indexOf(tecla) == -1 && !tecla_especial)
            return false;
    }
</script>

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
          </div>
        </div>
      </td>
    </tr>
  </table>
</header>


<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Cambiar Contraseña</h2>
                        
                    </div>
                    <?php
if (isset($_POST['cambiar'])) {
	//valido si el correo es correcto
    $correo = $_POST['correo'];
    $email = $_POST['correo'];
	// filter_var regresa los datos filtrados
	$correo = filter_var($correo, FILTER_VALIDATE_EMAIL);
	// regresa false si no son válidos
	if ($correo !== false) {


			$db=Db::conectar();
			$select=$db->prepare("SELECT * FROM usuario WHERE correo=  '$email'");
			$select->execute();
			$registro=$select->fetch();
			if($registro['id']!=NULL){
                
?>
<form class='' action='../Controladores/controladorUser.php' method='post'>

<div class='form-group '>            
    <label>Nueva Contraseña</label>
    <input required class='form-control' type='text' name='clave' onkeypress='return soloLetras(event)' onpaste='return false' maxlength='20' placeholder='Ingrese su nueva contraseña'>
</div>


<div class='form-group '>     
<input type='hidden'  name="id" value='<?php echo  $registro['id']; ?>' class="form-control">
    <input  type='hidden' name='actualizarContrasenia' value='actualizarContrasenia' class='form-control'>
    </div>


    <button class='btn btn-default'>Actualizar</button>  

<a href='index.php' class='btn btn-default'>Cancelar</a>
</form>

<?php

			}else{
				echo ' el correo ingresado  no existe';
			}	    
}
?>
       

   <?php
	} else {
        echo "La dirección $correo no es válida :)";
        echo('<p><a href="index.php">volver</a></p>');
	}

?>


                </div>
            </div>
        </div>
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