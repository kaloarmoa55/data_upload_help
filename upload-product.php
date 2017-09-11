<?php
  error_reporting(0);
  ini_set('display_errors', 0);
  require_once("funciones.php");
  ob_start("sanitize_output");
  require_once("head.php");
  require_once("conexion.php");
  $listablanca = array('intolerancia', 'nombre', 'texto', 'img');

    //variables
    $error = array();
    $fields = array();

    //Validacion
    if (! empty($_POST)) {
    //  print_r($_POST);
      if($_POST["seccion"] == "productos"){
        $seccion = "productos";
      }else{
        $seccion = "almacen";
      }

      if($_POST["categoria"] == "salados"){
        $categoria = "salados";
      }else{
        $categoria = "dulces";
      }

      if(isset($_POST["gluten"])){
        $gluten = "check";
      }else{
        $gluten = "uncheck";
      }

      if(isset($_POST["lactosa"])){
        $lactosa = "check";
      }else{
        $lactosa = "uncheck";
      }

      if(isset($_POST["azucar"])){
        $azucar = "check";
      }else{
        $azucar = "uncheck";
      }

      if(isset($_POST["caseina"])){
        $caseina = "check";
      }else{
        $caseina = "uncheck";
      }
      //limpiando datos
      foreach ($listablanca as $key) {
        $fields[$key] = $_POST[$key];
      }

      //segundo filtro de datos
      foreach ($fields as $field => $dat) {
        if (empty($dat)) {
          $error[] = "Porfavor, ingresa el siguiente campo: " . $field . "";
        }
      }

      if (empty($error)) {
        $cargardatos = "INSERT INTO productos(seccion, categoria, intolerancia, gluten, lactosa, azucar, caseina, nombre, texto, img) VALUES ('$seccion', '$categoria', '$fields[intolerancia]', '$gluten', '$lactosa', '$azucar', '$caseina', '$fields[nombre]', '$fields[texto]', '$fields[img]')";
        $res = mysqli_query($con, $cargardatos)or die(mysql_error());
        $done = "datos cargados con exito!.";
        $fields = array();

        mysqli_close($con);
      }
    }
  ?>
  <!DOCTYPE html>
  <html lang="es">
    <head>
      <meta charset="utf-8">
      <title>Carga de datos</title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
      <div class="cont">
        <p><?php echo $done; ?></p>
        <p><?php echo implode("</p><p>", $error); ?></p>
        <h1 id="titular">Carga de datos</h1>
        <br>
        <form action="upload-product.php" method="post">
          <select id="seccion" name="seccion" size="1">
            <option value="productos" selected="selected">Productos</option>
            <option value="almacen">Almacen</option>
          </select><br>
          <select id="categoria" name="categoria" size="1">
            <option value="salados" selected="selected">Salados</option>
            <option value="dulces">Dulces</option>
          </select><br>
          <input type="text" name="intolerancia" value="<?php echo isset( $fields['intolerancia']) ? _e($fields['intolerancia']) : ''; ?>" placeholder="Intolerancias"><br>
          <label for="gluten">Sin Gluten</label>
          <input type="checkbox" name="gluten" value=""><br>
          <label for="gluten">Sin Lactosa</label>
          <input type="checkbox" name="lactosa" value=""><br>
          <label for="gluten">Sin Azúcar</label>
          <input type="checkbox" name="azucar" value=""><br>
          <label for="gluten">Sin Caseína</label>
          <input type="checkbox" name="caseina" value=""><br>
          <input type="text" name="nombre" value="<?php echo isset( $fields['nombre']) ? _e($fields['nombre']) : ''; ?>" placeholder="Nombre:"><br>
          <input type="text" name="texto" value="<?php echo isset( $fields['texto']) ? _e($fields['texto']) : ''; ?>" placeholder="Descripción"><br>
          <input type="text" name="img" value="<?php echo isset( $fields['img']) ? _e($fields['img']) : ''; ?>" placeholder="Nombre de la Imagen"><br>
          <button type="submit" name="cargar">Cargar</button>
        </form>
        <br>
        <a href="?op=home">Volver a registros</a>
      </div>
    </body>
  </html>
