<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Actualizar SubCategoría</title>
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
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz()/,.";
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
        </tr>
    </table>
</header>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Actualizar Sub Categoría</h2>

                        <?php
                        require_once "../ConeccionBD/conexion.php";
                        $db = Db::conectar();
                        $id = $_GET['id'];
                        $select = $db->prepare('SELECT sub.id as id, sub.descripcion as descripcion, sub.estado as estado, cat.descripcion as categoria
                        FROM subcategoria AS sub INNER JOIN categoria AS cat
                        ON sub.idCategoria = cat.id
                        WHERE sub.id = ' . $id . '');
                        $select->execute();
                        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                        ?>

                            <form class="" action="../Controladores/controladorSubCategoria.php" method="post">

                                <div class="form-group ">
                                    <input required type="hidden" class="form-control" type="text" name="id" value="<?= $row['id'] ?>" style="display: none">
                                </div>

                                <div class="form-group">
                                    <label>Descripción</label>
                                    <input required class="form-control" type="text" name="descripcion" value="<?= $row['descripcion'] ?>" onkeypress="return soloLetras(event)" onpaste="return false" maxlength="200">
                                </div>

                                <div class="form-group">
                                    <label>Categoría Actual: <?= $row['categoria'] ?> </label>

                                    <select required name="idCategoria" class="form-control">
                                        <option value=""> Seleccionar Sub Categoría</option>
                                        <?php
                                        $db = Db::conectar();
                                        $select = $db->prepare('SELECT id, descripcion FROM categoria where estado =1');
                                        $select->execute();
                                        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option  value="' . $row['id'] . '">' . $row['descripcion'] . '</option>';
                                        } ?>
                                    </select>
                                </div>

                                <p>
                                    <input type="hidden" name="actualizar" value="actualizar" class="form-control">
                                    <button class="btn btn-default">Actualizar</button>
                                </p>

                                <a href="subCategoriasAdmin.php" class="btn btn-default">Cancelar</a>
                            </form>

                        <?php  } ?>
                        </select>
                    </div>
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