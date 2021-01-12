<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Administracion de Puntos Turisticos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link href="Css/formulario.css" rel="stylesheet" type="text/css" />
    <link href="Css/footer.css" rel="stylesheet" type="text/css" />
    <link href="Css/header.css" rel="stylesheet" type="text/css" />
    <link href="Css/tabla.css" rel="stylesheet" type="text/css" />
    <link href="Css/botonsalir.css" rel="stylesheet" type="text/css" />
</head>

<header>
    <div class="wrapper">
        <div class="logo">
            Ruta Escondida
        </div>
        <nav>
            <a>
                <form class="form" action="../Controladores/cerrarSesion.php" method="post">
                    <input type="hidden" name="salir" value="salir">
                    <button class="boton">Cerrar Sesión</button>
                </form>
            </a>
        </nav>
    </div>
</header>

<body>

    <?php
    $id = $_GET['id'];
    $idpt = $_GET['idpt'];
    $cat = $_GET['cat'];
    $d = $_GET['d'];
    ?>


    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Cambiar Imagen</h2>
                    </div>
                    <form class="" action="../Controladores/controladorImagen.php" method="post" enctype="multipart/form-data">

                        <div class="form-group ">
                            Imagen :
                            <input type="file" name="imagen" />
                        </div>

                        <div class="form-group ">
                            <input type="hidden" name="idPuntoTuristico" type="text" value='<?php echo $idpt; ?>'>
                            <input type="hidden" name="id" type="text" value='<?php echo $id; ?>'>
                            <input type="hidden" name="categoria" type="text" value='<?php echo $cat; ?>'>
                            <input type="hidden" name="direccion" type="text" value='<?php echo $d; ?>'>
                        </div>
                        <div class="form-group ">
                        </div>

                        <p>
                            <input type="hidden" name="actualizar" value="actualizar" class="form-control">
                            <button class="btn btn-default">Actualizar</button>
                        </p>
                        <a href="imagenesAdmin.php?id='<?php echo $idpt; ?>'" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>








</body>







</html>