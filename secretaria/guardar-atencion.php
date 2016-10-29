<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
  // Conexión a la Base de Datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  /******** Registrar una nueva atención ********/
  /**********************************************/
  //  Parámetros necesarios:
  // int_nro_atencion (GENERAR!)
  $sentencia = "call sp_taatencion_numero_atencion()";
  if (mysqli_multi_query($conexion, $sentencia)) {
    if ($resultado = mysqli_store_result($conexion)) {
      if ($fila = mysqli_fetch_row($resultado)) {
        $atencion = $fila[0];
        $atencion++;
      }
      else{
        $atencion = 1;
      }
    }
    mysqli_free_result($resultado);
  }
  mysqli_next_result($conexion);
  // chr_dni_paciente
  $identificador_paciente = $_POST["txtidentificador"];
  // chr_dni_usuario
  $usuario = $_SESSION["UsuarioLogueado"];
  // int_idservicio
  $idservicio = $_POST["txtservicio"];
  //dbl_pago
  $pago = $_POST["txtpago"];
  $pago = intval(substr($pago, 3));
  //int_orden (GENERAR!)
  $sentencia = "CALL spu_taatencion_numero_orden('$idservicio')";
  if (mysqli_multi_query($conexion, $sentencia)) {
    if ($resultado = mysqli_store_result($conexion)) {
      if ($fila = mysqli_fetch_row($resultado)) {
        $orden = $fila[0];
        $orden++;
      }
      else{
        $orden = 1;
      }
    }
    mysqli_free_result($resultado);
  }
  mysqli_next_result($conexion);

  // Finalmente, almacenamos la atención
  $sentencia = "CALL sp_taatencion_guardar($atencion, '$identificador_paciente', '$usuario', $idservicio, $pago, $orden);";
  if ($idservicio == 17 || $idservicio == 18 || $idservicio == 20) {
    $sentencia_aux = "CALL spu_taatencion_numero_orden(45)";
    if (mysqli_multi_query($conexion, $sentencia_aux)) {
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_row($resultado)) {
          $orden_aux = $fila[0];
          $orden_aux++;
        }
        else{
          $orden_aux = 1;
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
    $nro_atencion_aux = $atencion;
    $nro_atencion_aux++;
    $sentencia .= "CALL sp_taatencion_guardar($nro_atencion_aux, '$identificador_paciente', '$usuario', 45, 0, $orden_aux);";
  }
  if ($idservicio == 17 || $idservicio == 18) {
    $sentencia_aux = "CALL spu_taatencion_numero_orden(55)";
    if (mysqli_multi_query($conexion, $sentencia_aux)) {
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_row($resultado)) {
          $orden_aux = $fila[0];
          $orden_aux++;
        }
        else{
          $orden_aux = 1;
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
    $nro_atencion_aux++;
    $sentencia .= "CALL sp_taatencion_guardar($nro_atencion_aux, '$identificador_paciente', '$usuario', 55, 0, $orden_aux);";
  }
  if ($idservicio == 20) {
    $sentencia_aux = "CALL spu_taatencion_numero_orden(44)";
    if (mysqli_multi_query($conexion, $sentencia_aux)) {
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_row($resultado)) {
          $orden_aux = $fila[0];
          $orden_aux++;
        }
        else{
          $orden_aux = 1;
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
    $nro_atencion_aux++;
    $sentencia .= "CALL sp_taatencion_guardar($nro_atencion_aux, '$identificador_paciente', '$usuario', 44, 0, $orden_aux);";
    $sentencia_aux = "CALL spu_taatencion_numero_orden(80)";
    if (mysqli_multi_query($conexion, $sentencia_aux)) {
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_row($resultado)) {
          $orden_aux = $fila[0];
          $orden_aux++;
        }
        else{
          $orden_aux = 1;
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
    $nro_atencion_aux++;
    $sentencia .= "CALL sp_taatencion_guardar($nro_atencion_aux, '$identificador_paciente', '$usuario', 80, 0, $orden_aux);";
  }
  if (mysqli_multi_query($conexion, $sentencia)) {
    header("Location: confirmacion.php?nromensaje=7");
    exit;
  }
?>