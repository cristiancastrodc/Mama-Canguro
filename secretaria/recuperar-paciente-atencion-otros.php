<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
  // DNI del paciente
  $dni_paciente = $_GET["dni"];
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Sentencia para recuperar los datos de un paciente utilizando su DNI
  $sentencia ="CALL sp_tapaciente_listar('$dni_paciente')";
  if (mysqli_multi_query($conexion, $sentencia)) {
    if ($resultado = mysqli_store_result($conexion)) {
      $cuenta = mysqli_num_rows($resultado);
      // Si existe ese paciente con ese DNI
      if ($cuenta == 1) {
        $paciente = mysqli_fetch_array($resultado);
        // Recuperamos nombres, apellidos e identificador del paciente
        $nombres = $paciente["vch_nombres"];
        $apellidos = $paciente["vch_apellidos"];
        $idpaciente = $paciente["chr_dni_paciente"];
        mysqli_free_result($resultado);
        mysqli_next_result($conexion);
        $nombre_completo = utf8_encode($nombres.' '.$apellidos);
        echo json_encode(
          array(
          'existePaciente' => 1,
          'divPaciente' => "<input type='hidden' value='$idpaciente' id='txtidentificador' name='txtidentificador'></input>"."<div class='form-group'>"."<label class='col-sm-2 control-label'>Nombre del Paciente:</label>"."<div class='col-sm-4'>"."<input type='text' class='form-control round-form' id='txtNombre' name='txtNombre' value='$nombre_completo' readonly></input>"."</div>"."</div>"
          )
        );
      } else {
        mysqli_free_result($resultado);
        mysqli_next_result($conexion);
        echo json_encode(
          array(
          'existePaciente' => 0,
          'divPaciente' => "<div class='alert alert-danger center-align'><b>Paciente no registrado! Por favor, previamente registre los datos del paciente.</b></div>"."<a href='filiacion.php' role='button' class='btn btn-primary btn-lg btn-block' accesskey='r'>Registrar al paciente (Alt + R)</a>"
          )
        );
      }
    }
  }
?>