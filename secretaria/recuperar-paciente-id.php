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
  // Recuperar el id del paciente
  $id = $_GET['id'];
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Consulta
  $sentencia ="CALL sp_tapaciente_listar_id('$id')";
  $resultado = mysqli_query($conexion,$sentencia);
  $nro_filas = mysqli_num_rows($resultado);
  if ($nro_filas > 0) {
  	if($fila = mysqli_fetch_array($resultado)) {
      $nombres = $fila["vch_nombres"];
      $nombres = utf8_encode($nombres);
      $apellidos = $fila["vch_apellidos"];
      $apellidos = utf8_encode($apellidos);
      $fecha_nacimiento = $fila["dat_fecha_nac"];
      $fecha_nacimiento = strtotime($fecha_nacimiento);
      $dia_nacimiento = date('d', $fecha_nacimiento);
      $mes_nacimiento = date('m', $fecha_nacimiento);
      $year_nacimiento = date('Y', $fecha_nacimiento);
      $domicilio = $fila["vch_domicilio"];
      $domicilio = utf8_encode($domicilio);
      $ocupacion = $fila["vch_ocupacion"];
      $ocupacion = utf8_encode($ocupacion);
      $doc_id = $fila["chr_doc_id"];
      if (is_null($doc_id)) {
        $readonly = "";
      } else {
        $readonly = "readonly";
      }

      echo "<input type='hidden' id='txtdni1' name='txtdni1' value='".$fila['chr_dni_paciente']."'>";
      echo "<div class='form-group'>";
        echo "<label class='col-lg-2 control-label'>DNI:</label>";
        echo "<div class='col-lg-4'>";
          echo "<input type='text' class='form-control round-form' id='txtdocid' name='txtdocid' value='$doc_id' required maxlength='8' $readonly>";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        echo "<label class='col-lg-2 control-label'>NOMBRES:</label>";
        echo "<div class='col-lg-4'>";
          echo "<input type='text' class='form-control round-form' id='txtnombres1' name='txtnombres1' value='$nombres' required>";
        echo "</div>";
        echo "<label class='col-lg-2 control-label'>APELLIDOS:</label>";
        echo "<div class='col-lg-4'>";
          echo "<input type='text' class='form-control round-form' id='txtapellidos1' name='txtapellidos1' value='$apellidos' required>";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        echo "<label class='col-lg-2 control-label'>FECHA DE NACIMIENTO:</label>";
        echo "<div class='col-lg-1'>";
          echo "<input type='number' class='form-control round-form' id='txtDia' name='txtDia' value='$dia_nacimiento' required placeholder='dd'>";
        echo "</div>";
        echo "<div class='col-lg-1'>";
          echo "<input type='number' class='form-control round-form' id='txtMes' name='txtMes' value='$mes_nacimiento' required placeholder='mm'>";
        echo "</div>";
        echo "<div class='col-lg-2'>";
          echo "<input type='number' class='form-control round-form' id='txtYear' name='txtYear' value='$year_nacimiento' required placeholder='aaaa'>";
        echo "</div>";
        $hoy = date('Y');
        $nacimiento = strtotime($fila['dat_fecha_nac']);
        $nacimiento = date('Y', $nacimiento);
        $edad = $hoy - $nacimiento;
        echo "<label class='col-lg-2 control-label'>EDAD:</label>";
        echo "<div class='col-lg-4'>";
          echo "<input type='text' class='form-control round-form' id='txtedad' name='txtedad' value='$edad' readonly>";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        echo "<label class='col-lg-2 control-label'>DOMICILIO:</label>";
        echo "<div class='col-lg-4'>";
          echo "<input type='text' class='form-control round-form' id='txtdomicilio' name='txtdomicilio' value='$domicilio'>";
        echo "</div>";
        echo "<label class='col-lg-2 control-label'>TELÉFONO:</label>";
        echo "<div class='col-lg-4'>";
          echo "<input type='text' class='form-control round-form' id='txttelefono' name='txttelefono' value='".$fila['vch_telefono']."'>";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        $sexos = array('F', 'M');
        echo "<label class='col-lg-2 control-label'>SEXO:</label>";
        echo "<div class='col-lg-4'>";
          echo "<select class='form-control' id='txtsexo' name='txtsexo'>";
          echo "<option>".$fila['chr_sexo']."</option>";
          for ($i=0; $i < 2; $i++) {
            if ($sexos[$i] != $fila['chr_sexo']) {
              echo "<option>$sexos[$i]</option>";
            }
          }
          echo "</select>";
        echo "</div>";
        echo "<label class='col-lg-2 control-label'>OCUPACION:</label>";
        echo "<div class='col-lg-4'>";
          echo "<input type='text' class='form-control round-form' id='txtocupacion' name='txtocupacion' value='$ocupacion'>";
        echo "</div>";
      echo "</div>";
      echo "<div class='form-group'>";
        $grados = array('Ninguno', 'Primaria', 'Secundaria', 'Universitaria');
        echo "<label class='col-lg-2 control-label'>GRADO DE INSTRUCCION:</label>";
        echo "<div class='col-lg-4'>";
          echo "<select class='form-control' id='txtgrado' name='txtgrado'>";
          echo "<option>".$fila['vch_grado_instruccion']."</option>";
          for ($i=0; $i < 4; $i++) {
            if ($grados[$i] != $fila['vch_grado_instruccion']) {
              echo "<option>$grados[$i]</option>";
            }
          }
          echo "</select>";
        echo "</div>";
        $estados = array('Soltero(a)', 'Casado(a)', 'Conviviente', 'Viudo(a)', 'Divorciado(a)');
        echo "<label class='col-lg-2 control-label'>ESTADO CIVIL:</label>";
        echo "<div class='col-lg-4'>";
          echo "<select class='form-control' id='txtestado' name='txtestado'>";
          echo "<option>".$fila['vch_estado_civil']."</option>";
          for ($i=0; $i < 5; $i++) {
            if ($estados[$i] != $fila['vch_estado_civil']) {
              echo "<option>$estados[$i]</option>";
            }
          }
          echo "</select>";
        echo "</div>";
      echo "</div>";
      echo "<button type='submit' class='btn btn-success btn-block btn-lg' accesskey='g'>GUARDAR (Alt + G)</button>";
  	}
  }
  mysqli_close($conexion);
?>