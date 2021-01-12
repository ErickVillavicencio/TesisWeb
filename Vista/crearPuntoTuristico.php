<?php
require_once('../Modelo/usuario.php');
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
}
?>
<?php
require_once "../ConeccionBD/conexion.php";
$db = Db::conectar();
$select = $db->prepare('SELECT id, descripcion FROM categoria WHERE estado = 1');
$select->execute();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Crear Punto Turístico</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link href="Css/formulario.css" rel="stylesheet" type="text/css" />
    <link href="Css/footer.css" rel="stylesheet" type="text/css" />
    <link href="Css/header.css" rel="stylesheet" type="text/css" />
    <link href="Css/botonsalir.css" rel="stylesheet" type="text/css" />
    <link href="Css/tabla.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script language="javascript" src="js/jquery-3.4.1.min.js"></script>
</head>

<script type="text/javascript">
    $(document).ready(function() {
        $("#categoria").change(function() {

            $("#categoria option:selected").each(function() {
                idCat = $(this).val();
                $.post("../Controladores/consulta.php", {
                    idCat: idCat
                }, function(data) {
                    $("#subCategoria").html(data);
                });
            });
        })
    });
</script>

<script>
    function soloLetrasNumeros(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.,0123456789-_:;()@";
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

<script>
    function soloNumeros(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = "-:,.0123456789";
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

    <?php
    $nombreUsuario = $_SESSION['usuario']->getUsuario();
    $idUsuario = $_SESSION['usuario']->getId();
    ?>


    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Registrar Puntos Turísticos</h2>
                    </div>
                    <form class="" action="../Controladores/controladorPuntoTuristico.php" method="post" enctype="multipart/form-data">

                        <div class="form-group ">
                            <label>Nombre</label>
                            <input required class="form-control" type="text" name="nombre" onkeypress="return soloLetras(event)" maxlength="100" placeholder="Ingrese el nombre del Punto Turístico">
                        </div>

                        <div class="form-group ">
                            <label>Descripción</label>
                            <textarea required class="form-control" name="descripcion" rows="10" cols="50" onkeypress="return soloLetrasNumeros(event)" maxlength="900"></textarea>
                        </div>

                        <div class="form-group ">
                            <label>Latitud</label>
                            <input required class="form-control" step="any" type="text" name="latitud" placeholder="000.000000" soloNumeros(event)" maxlength="11">
                        </div>

                        <div class="form-group ">
                            <label>Longuitud</label>
                            <input required class="form-control" step="any" type="text" name="longuitud" placeholder="000.000000" soloNumeros(event)" maxlength="11">
                        </div>

                        <div>
                            <input name="ceador" type="text" value="<?php echo $idUsuario; ?>" style="visibility:hidden" name="creador">
                        </div>

                        <div class="form-group ">
                            <label>Categoría</label>
                            <select required name="categoriaId" id="categoria" class="form-control">
                                <option value="">Seleccionar Categoría</option>
                                <?php
                                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['descripcion'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Sub Categoría</label>
                            <select required name="subCategoriaId" id="subcategoria" class="form-control">
                                <option value="">Seleccione la Sub Categoría</option>
                            </select>
                        </div>

                        <div class="form-group ">
                            <label>Costo Adulto</label>
                            <input required class="form-control" step="000.50" type="number" name="costo" placeholder="00.00" onkeypress="return soloNumeros(event)" maxlength="7">
                        </div>

                        <div class="form-group ">
                            <label>Costo Niño</label>
                            <input required class="form-control" step="000.50" type="number" name="costoN" placeholder="00.00" onkeypress="return soloNumeros(event)" maxlength="7">
                        </div>

                        <div class="form-group">
                            <label>Parroquia</label>
                            <select required name="idParroquia" class="form-control">
                                <option value="">Seleccionar Parroquia</option>
                                <?php
                                $db = Db::conectar();
                                $select = $db->prepare('SELECT id, descripcion FROM parroquia WHERE estado = 1');
                                $select->execute();
                                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['descripcion'] . '</option>';
                                } ?>
                            </select>
                        </div>

                        <div class="form-group ">
                            <label>Tiempo Estimado (h/m/s)</label>
                            <input required class="form-control" type="time" name="tiempoEstimado" VALUE="00:00:00" max="22:30:00" min="00:01:00" step="1" onkeypress="return soloNumeros(event)">
                        </div>

                        <div class="form-group ">
                            <label>Facebook</label>
                            <input  class="form-control" type="text" name="facebook"  maxlength="200" placeholder="Ingrese el link de Facebook">
                        </div>

                        <div class="form-group ">
                            <label>Twitter</label>
                            <input  class="form-control" type="text" name="twitter"  maxlength="200" placeholder="Ingrese el link de Twitter">
                        </div>

                        <div class="form-group ">
                            <label>Instagram</label>
                            <input  class="form-control" type="text" name="instagram"  maxlength="200" placeholder="Ingrese el link de Instagram">
                        </div>

                        <div class="form-group ">
                            <label>Imagen Principal:</label>
                            <input required type="file" name="imagen" />
                        </div>
                        <div class="form-group ">
                            <label>Imagen 2:</label>
                            <input required type="file" name="imagen2" />
                        </div>
                        <div class="form-group ">
                            <label>Imagen 3:</label>
                            <input required type="file" name="imagen3" />
                        </div>

                        <p>
                            <input type="hidden" name="registrar" value="registrar" class="form-control">
                            <button class="btn btn-default">Registrar</button>
                        </p>
                        <a href="PuntosAdmin.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="separador">
        __________________________________________________________________________________________________
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