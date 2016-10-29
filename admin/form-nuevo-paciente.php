<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if (!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('admin');
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Recuperamos el identificador del ultimo paciente
  $sentencia ="CALL sp_tapaciente_ultimo_identificador()";
  $resultado = mysqli_query($conexion, $sentencia);
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
  echo "<form class='form-horizontal style-form' method='POST' action='actualizar-datos-paciente.php'>";
  echo "<input type='hidden' id='txtIdPaciente' name='txtIdPaciente' value='$nuevo_id'>";
  echo "<div class='alert alert-danger black text-center'>Antes de registrar al paciente, asegúrese que no esté ya registrado y que el DNI no se repita.</div>";
  echo "<div class='form-group'>";
    echo "<label class='col-sm-2 control-label'>DNI:</label>";
    echo "<div class='col-sm-4'>";
      echo "<input type='text' class='form-control round-form' id='txtDNI' name='txtDNI' required maxlength='8'>";
    echo "</div>";
    echo "<label class='col-sm-2 control-label'>Fecha de nacimiento:</label>";
    echo "<div class='col-sm-1'>";
      echo "<input type='number' class='form-control round-form' id='txtDia' name='txtDia' min='1' max='31' placeholder='dd'>";
    echo "</div>";
    echo "<div class='col-sm-1'>";
      echo "<input type='number' class='form-control round-form' id='txtMes' name='txtMes' min='1' max='12' placeholder='mm'>";
    echo "</div>";
    echo "<div class='col-sm-2'>";
      echo "<input type='text' class='form-control round-form' id='txtYear' name='txtYear' maxlength='4' placeholder='yyyy'>";
    echo "</div>";
  echo "</div>";
  echo "<div class='form-group'>";
    echo "<label class='col-sm-2 control-label'>Nombres:</label>";
    echo "<div class='col-sm-4'>";
      echo "<input type='text' class='form-control round-form' id='txtNombres' name='txtNombres' required maxlength='8'>";
    echo "</div>";
    echo "<label class='col-sm-2 control-label'>Apellidos</label>";
    echo "<div class='col-sm-4'>";
      echo "<input type='text' class='form-control round-form' id='txtApellidos' name='txtApellidos' required>";
    echo "</div>";
  echo "</div>";
  echo "<div class='form-group'>";
    echo "<label class='col-lg-2 control-label'>Domicilio:</label>";
    echo "<div class='col-lg-4'>";
      echo "<input type='text' class='form-control round-form' id='txtDomicilio' name='txtDomicilio'>";
    echo "</div>";
    echo "<label class='col-lg-2 control-label'>Teléfono:</label>";
    echo "<div class='col-lg-4'>";
      echo "<input type='text' class='form-control round-form' id='txtTelefono' name='txtTelefono'>";
    echo "</div>";
  echo "</div>";
  echo "<div class='form-group'>";
    $sexos = array('F', 'M');
    echo "<label class='col-xs-2 control-label'>Sexo:</label>";
    echo "<div class='col-xs-4'>";
      echo "<select class='form-control' id='txtSexo' name='txtSexo'>";
      echo "<option></option>";
      for ($i=0; $i < 2; $i++) {
        echo "<option>$sexos[$i]</option>";
      }
      echo "</select>";
    echo "</div>";
    echo "<label class='col-lg-2 control-label'>Ocupación:</label>";
    echo "<div class='col-lg-4'>";
      echo "<input type='text' class='form-control round-form' id='txtOcupacion' name='txtOcupacion'>";
    echo "</div>";
  echo "</div>";
  echo "<div class='form-group'>";
    $grados = array('Ninguno', 'Primaria', 'Secundaria', 'Universitaria');
    echo "<label class='col-sm-2 control-label'>Grado de instrucción:</label>";
    echo "<div class='col-sm-4'>";
      echo "<select class='form-control' id='txtGrado' name='txtGrado'>";
      echo "<option></option>";
      for ($i=0; $i < 4; $i++) {
        echo "<option>$grados[$i]</option>";
      }
      echo "</select>";
    echo "</div>";
    $estados = array('Soltero(a)', 'Casado(a)', 'Conviviente', 'Viudo(a)', 'Divorciado(a)');
    echo "<label class='col-sm-2 control-label'>Estado civil:</label>";
    echo "<div class='col-sm-4'>";
      echo "<select class='form-control' id='txtEstado' name='txtEstado'>";
      echo "<option></option>";
      for ($i=0; $i < 5; $i++) {
        echo "<option>$estados[$i]</option>";
      }
      echo "</select>";
    echo "</div>";
  echo "</div>";
  echo "<button type='submit' class='btn btn-primary btn-block'><i class='fa fa-check'></i> GUARDAR (Alt + G)</button>";
  echo "</form>";
?>