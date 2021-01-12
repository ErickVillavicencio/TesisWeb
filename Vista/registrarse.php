<!DOCTYPE html>
<html>

<head>
	<title>Registrarse</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="Css/formulario.css" rel="stylesheet" type="text/css" />
	<link href="Css/footer.css" rel="stylesheet" type="text/css" />
	<link href="Css/header.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
	<a id="logo-header" href="#">
		<span class="site-name">Ruta Escondida</span>
		<span class="site-desc">Perucho / Puellaro / Chavezpamba</span>
	</a>
	<div class="header">
		<div class="header-right">
			<a href="index.php">Login</a>
			<a href="registrarse.php" class="active">Registro</a>
		</div>
	</div>
</header>

<body>
	<div class="wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="page-header">

						<form class="" action="../Controladores/controladorLogin.php" method="post">

							<div class="form-group">
								<label>Nombres</label>
								<input required class="form-control" type="text" name="nombres" onkeypress="return soloLetras(event)" onpaste="return false" maxlength="100" placeholder="Ingrese sus dos nombres">

							</div>

							<div class="form-group">
								<label>Apellidos</label>
								<input required class="form-control" type="text" name="apellidos" onkeypress="return soloLetras(event)" onpaste="return false" maxlength="150" placeholder="Ingrese sus dos apellidos">
							</div>

							<div class="form-group">
								<label>Nombre de Usuario</label>
								<input required class="form-control" type="text" name="usuario" onkeypress="return soloLetrasyNumeros(event)" onpaste="return false" maxlength="10" placeholder="Ingrese un nombre de usuario">
							</div>

							<div class="form-group">
								<label>Contraseña</label>
								<input required class="form-control"  name="pas" max="15" onkeypress="return soloLetrasyNumeros(event)" onpaste="return false" maxlength="15" placeholder="Ingrese una contraseña">
							</div>

							<div class="form-group">
								<label>Correo</label>
								<input required class="form-control" onkeypress="return soloLetrasyNumeros(event)" onpaste="return false" type="text" name="correo" maxlength="100" placeholder=" Ingrese su Correo">
							</div>

							<input class="" type="number" value="3" style="visibility:hidden" name="rol">
							<input type="hidden" name="registrarse" value="registrarse" class="form-control">
							<button class="">Registrarse</button>
							</p>
							<p><a href="index.php">Ahora no</a></p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<footer>
		<p>Company © Ruta Escondida. All rights reserved.</p>
	</footer>

</body>

</html>