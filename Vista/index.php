<?php
session_start();
unset($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html>

<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="Css/formulario.css" rel="stylesheet" type="text/css" />
	<link href="Css/footer.css" rel="stylesheet" type="text/css" />
	<link href="Css/header.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
</head>

<script>
	function soloLetrasyNumeros(e) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = " áéíóúabcdefghijklmnñopqrstuvwxyz1234567890@.";
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
     <tr >
         <td>  
         <a id="logo-header">
        <span class="site-name"> <img src="imagenes\pagina\Logo.png"  width="70"  height="70">  Generador de Rutas Personalizadas</span>
        <span class="site-desc">Perucho / Chavezpamba / Puéllaro</span>
    </a>
</td>
         <td style="margin-right: 0px;">
		 <div class="header">
		<div class="header-right">
			<a href="index.php" class="active">Login</a>
			<a href="registrarse.php">Registro</a>
		</div>
	</div>
    </td>
     </tr>
 </table>  
 <br>
 </header>



<body>
    <br>
	<div class="wrapper">
		<div class="page-header">
			<form action="../Controladores/controladorLogin.php" method="post">

				<div class="form-group">
					<label>Usuario</label>
					<input class="form-control" onkeypress="return soloLetrasyNumeros(event)" onpaste="return false" type="text" name="usuario" maxlength="10" placeholder="Nombre de Usuario">
				</div>

				<div class="form-group">
					<label>Contraseña</label>
					<input class="form-control" onkeypress="return soloLetrasyNumeros(event)" onpaste="return false" type="text" name="pas" maxlength="15" placeholder="Contraseña">
				</div>

				<p>
					<input type="hidden" name="entrar" value="entrar" class="form-control">
					<button class="botonAceptar">Aceptar</button>
				</p>
			</form>

	<p><a href="correo.php">Olvidaste tu Contraseña</a></p>
	</div>
	</div>
<br>

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