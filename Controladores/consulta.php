<?php
require_once "../ConeccionBD/conexion.php"; //libreria de conexion a la base

$subCat_id = filter_input(INPUT_POST, 'subCat_id'); //obtenemos el parametro que viene de ajax

if($subCat_id != ''){ //verificamos nuevamente que sea una opcion valida    
  /*Obtenemos los discos de la banda seleccionada*/
  $db = Db::conectar();
  $select = $db->prepare("select * from subcategoria where estado = 1 AND   idCategoria = ".$subCat_id);
  $select->execute();
}
?>

<option value="">- Seleccione -</option>

<?php
 while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
echo '<option value="' . $row['id'] . '">' . $row['descripcion'] . '</option>';
} ?>
