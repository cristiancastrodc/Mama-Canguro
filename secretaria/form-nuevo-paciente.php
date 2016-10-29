<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
  // Asignamos la zona horaria, para cálculos con fechas
  date_default_timezone_set('America/Lima');
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Recuperamos el identificador del ultimo paciente
  $sentencia ="CALL sp_tapaciente_ultimo_identificador()";
  $resultado = mysqli_query($conexion,$sentencia);
  /************************************************
  Generamos el próximo identificador
  ************************************************/
  $fila = mysqli_fetch_array($resultado);
  $id = $fila["identificador"];
  $nuevo_id = substr($id, 2, 6);
  $nuevo_id = intval($nuevo_id);
  $nuevo_id++;
  $nuevo_id = strval($nuevo_id);
  $cuenta = strlen($nuevo_id);
  for ($i=$cuenta; $i < 6; $i++) {
  	$nuevo_id = '0'.$nuevo_id;
  }
  $nuevo_id = 'MC'.$nuevo_id;
  /***********************************************/
  echo "<input type='hidden' id='txtdni1' name='txtdni1' value='$nuevo_id'>";
  echo "<div class='form-group mt'>";
    echo "<label class='col-lg-2 control-label'>DNI:</label>";
    echo "<div class='col-lg-4'>";
      echo "<input type='text' class='form-control round-form' id='txtdocid' name='txtdocid' required maxlength='8'>";
    echo "</div>";
    echo "<label class='col-lg-2 control-label'>FECHA DE NACIMIENTO:</label>";
    echo "<div class='col-lg-1'>";
      echo "<input type='number' class='form-control round-form' id='txtDia' name='txtDia' required placeholder='dd' min='1' max='31'>";
    echo "</div>";
    echo "<div class='col-lg-1'>";
      echo "<input type='number' class='form-control round-form' id='txtMes' name='txtMes' required placeholder='mm' min='1' max='12'>";
    echo "</div>";
    echo "<div class='col-lg-2'>";
      echo "<input type='number' class='form-control round-form' id='txtYear' name='txtYear' required placeholder='aaaa' min='1900'>";
    echo "</div>";
  echo "</div>";
  echo "<div class='form-group'>";
    echo "<label class='col-lg-2 control-label'>DOMICILIO:</label>";
    echo "<div class='col-lg-4'>";
      echo "<input type='text' class='form-control round-form' id='txtdomicilio' name='txtdomicilio'>";
    echo "</div>";
    echo "<label class='col-lg-2 control-label'>TELÉFONO:</label>";
    echo "<div class='col-lg-4'>";
      echo "<input type='text' class='form-control round-form' id='txttelefono' name='txttelefono'>";
    echo "</div>";
  echo "</div>";
  echo "<div class='form-group'>";
    $sexos = array('F', 'M');
    echo "<label class='col-lg-2 control-label'>SEXO:</label>";
    echo "<div class='col-lg-4'>";
      echo "<select class='form-control' id='txtsexo' name='txtsexo'>";
      echo "<option></option>";
      for ($i=0; $i < 2; $i++) {
        echo "<option>$sexos[$i]</option>";
      }
      echo "</select>";
    echo "</div>";
    echo "<label class='col-lg-2 control-label'>OCUPACION:</label>";
    echo "<div class='col-lg-4'>";
      echo "<input type='text' class='form-control round-form' id='txtocupacion' name='txtocupacion'>";
    echo "</div>";
  echo "</div>";
  echo "<div class='form-group'>";
    $grados = array('Ninguno', 'Primaria', 'Secundaria', 'Universitaria');
    echo "<label class='col-lg-2 control-label'>GRADO DE INSTRUCCION:</label>";
    echo "<div class='col-lg-4'>";
      echo "<select class='form-control' id='txtgrado' name='txtgrado'>";
      echo "<option></option>";
      for ($i=0; $i < 4; $i++) {
        echo "<option>$grados[$i]</option>";
      }
      echo "</select>";
    echo "</div>";
    $estados = array('Soltero(a)', 'Casado(a)', 'Conviviente', 'Viudo(a)', 'Divorciado(a)');
    echo "<label class='col-lg-2 control-label'>ESTADO CIVIL:</label>";
    echo "<div class='col-lg-4'>";
      echo "<select class='form-control' id='txtestado' name='txtestado'>";
      echo "<option></option>";
      for ($i=0; $i < 5; $i++) {
        echo "<option>$estados[$i]</option>";
      }
      echo "</select>";
    echo "</div>";
  echo "</div>";
  echo "<button type='submit' class='btn btn-success btn-lg btn-block'>GUARDAR (Alt + G)</button>";
?>