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
    <link href="Css/paginator.css" rel="stylesheet" type="text/css" />
    <link href="Css/tabla.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 






</head>

<header id="main-header">
    <a id="logo-header" href="#">
        <span class="site-name">Ruta Escondida</span>
        <span class="site-desc">Perucho / Puellaro / Chavezpamba</span>
    </a>
    <div class="header">
        <div class="header-right">
            <a href="ParroquiasAdmin.php">Parroquias</a>
            <a href="categoriasAdmin.php">Categorías</a>
            <a class="active" href="subCategoriasAdmin.php">Sub Categorías</a>
            <a href="PuntosAdmin.php">Puntos Turisticos</a>
            <a>
                <form class="form" action="../Controladores/cerrarSesion.php" method="post">
                    <input type="hidden" name="salir" value="salir">
                    <button class="botonCerrar">Cerrar Sesión</button>
                </form>
            </a></li>
        </div>
    </div>
</header>

<body>    





<?php
 require_once "../ConeccionBD/conexion.php";
//consulta para el paginador
$dbs = Db::conectar();
$select = $dbs->prepare('SELECT COUNT(*) as totalRegistros From subcategoria');
$select->execute();
$resultado = $select->fetch();

$total_registro = $resultado['totalRegistros'];
$por_pagina = 10  ;
if (empty($_GET['pagina'])) {
    $pagina = 1;
} else {
    $pagina = $_GET['pagina'];
}
$desde = ($pagina - 1) * $por_pagina;
$total_paginas = ceil($total_registro / $por_pagina);
unset($dbs);


                   
                    $sql = "SELECT sub.id as id, sub.descripcion as descripcion, sub.estado as estado, cat.descripcion as categoria
                    FROM subcategoria AS sub INNER JOIN categoria AS cat
                    ON sub.idCategoria = cat.id ORDER BY sub.estado DESC , sub.id ASC
                    LIMIT $desde,$por_pagina";
                    $pdo = Db::conectar();
                    if ($result = $pdo->query($sql)) {
                        if ($result->rowCount() > 0) {

                          $subCategoria = array();
                          $i = 0;
                            while ($row = $result->fetch()) {                                
                                $subCategoria[$i]['id'] = $row['id'];
                                $subCategoria[$i]['categoria'] = $row['categoria'];
                                $subCategoria[$i]['descripcion'] = $row['descripcion'];
                                $subCategoria[$i]['estado'] = $row['estado'];
                                $i++;
                            }
                          }
                            else {
                              echo "<p class='lead'><em>No se encontraron resultados.</em></p>";
                          }
                            }
                        else {
                            echo "ERROR: No se pudo Ejecutar $sql. " . $mysqli->error;
                          }
                       
                    unset($pdo);
                    $longitud = count($subCategoria);


?>





<div class="tablaborde">


<br>
        <div class="col-md-12">
            <h2 class="pull-left">Parroquias</h2>
            <a href="crearParroquia.php" class="btn btn-success pull-right">Agregar nueva Parroquia</a>
        </div>


<table class='container'>
<tr>
<th></th>
<th><label> Buscar por Categoría: </label>&nbsp;<input type="text" class="buscador" id="categoria" onkeyup="buscarCategoria()" placeholder="Buscar por Categoría.." title="Type in a name"></th>  
<th><label> Buscar por Sub Categoría: </label>&nbsp;<input type="text" class="buscador" id="subCategoria" onkeyup="buscarSubCategoria()" placeholder="Buscar por Sub Categoria.." title="Type in a name"></th>
</tr>

</table>


<table id="myTable" class='container'>

<tr>
<th>#</th>
<th>Categoría Perteneciente</th>  
<th>SubCategoría</th>
<th>Estado</th>                          
<th>Acción</th>
</tr>


<?php

for($i = 0; $i < $longitud; $i++){
  echo "<tr>";
  echo "<td>" .  $subCategoria[$i]['id'] . "</td>";
  echo "<td>" . $subCategoria[$i]['categoria'] . "</td>";
echo "<td>" . $subCategoria[$i]['descripcion'] . "</td>";
echo "<td>";
if( $subCategoria[$i]['estado']  == 1){
    echo  "Activo";
} else{
    echo  "Eliminado";
}                                
"</td>";
echo "<td>";
if( $subCategoria[$i]['estado'] == 1){
  echo "<a href='actualizarSubCategoria.php?id=" . $subCategoria[$i]['id'] . "' title='Actualizar Parroquia' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a> &nbsp;";
  echo "<a href='eliminarSubCategoria.php?id=" . $subCategoria[$i]['id'] . "' title='Eliminar Parroquia' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";  
 }else{
  echo "<a href='activarSubCategoria.php?id=" . $subCategoria[$i]['id'] . "' title='Activar Parroquia ' data-toggle='tooltip'><span class='glyphicon glyphicon-ok'></span></a>";
             }
             echo "</td>";
echo "</tr>";
}
?>


</table>

<div class="paginator">
        <ul>
            <?php
            if ($pagina != 1) {
            ?>
                <li><a href="?pagina=<?php echo 1; ?>">|<<</a> </li> <li><a href="?pagina=<?php echo $pagina - 1; ?>">
                                <<</a> </li> <?php
                                            }
                                            for ($i = 1; $i <= $total_paginas; $i++) {

                                                if ($i == $pagina) {
                                                    echo '<li class="pageSelected">' . $i . '</li>';
                                                } else {
                                                    echo '<li><a href="?pagina=' . $i . '">' . $i . '</a></li>';
                                                }
                                            }
                                            if ($pagina != $total_paginas) {
                                                ?> <li><a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
                <li><a href="?pagina=<?php echo $total_paginas ?>">>>|</a></li>
            <?php
                                            }
            ?>
        </ul>
    </div>









</div>
    <footer>
        <p>Company © Ruta Escondida. All rights reserved.</p>
    </footer>

</body>
</html>

<script>
function buscarCategoria() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("categoria");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function buscarSubCategoria() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("subCategoria");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>