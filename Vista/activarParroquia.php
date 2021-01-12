<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Activar Parroquia</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link href="Css/popup.css" rel="stylesheet" type="text/css" />
    <link href="Css/footer.css" rel="stylesheet" type="text/css" />
    <link href="Css/header.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
        </tr>
    </table>
</header>
    
<body>
<div id="popup" class="overlay">
        <div id="popupBody">
            <h2>Activar Parroquia</h2>
            <a id="cerrar" href="ParroquiasAdmin.php">&times;</a>
            <div class="popupContent">
            <?php   
                        require_once "../ConeccionBD/conexion.php";
                        $db = Db::conectar();
                        $id = $_GET['id'];
                        $select = $db->prepare('SELECT * from parroquia WHERE id = '.$id.'');
                        $select->execute();
                        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <form class="" action="../Controladores/controladorParroquia.php" method="post">

                                <div class="form-group ">
                                    <input class="form-control" type="text" name="id" value="<?= $row['id'] ?>" style="display: none">
                                </div>
                                <div class="form-group ">
                                    <label>De verdad deseea volver a Activar la Parroquia "<?php 
                                    $nombre = $row['descripcion'];
                                    echo($nombre); ?>"</label>
                                </div>                               
                                </div>
                                <p>
                                    <input type="hidden" name="activar" value="activar" class="form-control">
                                    <button class="">Activar</button>    
                                    <button class=""><a href="ParroquiasAdmin.php">Cancelar</a></button>                                
                            </form> 
                        <?php  } ?>
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