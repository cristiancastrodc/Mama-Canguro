<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('secretaria');
  // Recuperar parámetros enviados por GET
  $id_paciente = $_GET["idpaciente"];
  $id_servicio = $_GET["servicio"];
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);

  /* En la siguiente sección se hacen las validaciones para que muestre los datos necesarios de acuerdo al tipo de servicio requerido
  Los casos especiales son:
  1.  (11) Control Medicina General,
      (12) Control Ginecología y
      (13) Control Pediatría :
      Se debe mostrar la fecha de la próxima cita del paciente para hacer el control efectivo.
  2. (19) Paquete de parto:
      Se debe de mostrar la fecha de la próxima cita, así como la tabla de pagos del paciente.
  */
  if ($id_servicio == 11 || $id_servicio == 12 || $id_servicio == 13 || $id_servicio == 19) {
    $sentencia = "CALL sp_tapaciente_proxima_cita('$id_paciente')";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        if ($fila = mysqli_fetch_array($resultado)) {
          $fecha_consulta = $fila["fechaconsulta"];
          $fecha_proxima_cita = $fila["fechaproximacita"];
          echo "<div class='form-group'>";
            echo "<label class='col-sm-3 control-label'>Fecha de última atención:</label>";
            echo "<div class='col-sm-3'>";
              echo "<input type='text' class='form-control round-form' value='$fecha_consulta' readonly>";
            echo "</div>";
            echo "<label class='col-sm-3 control-label'>Fecha de próxima cita:</label>";
            echo "<div class='col-sm-3'>";
              echo "<input type='text' class='form-control round-form' value='$fecha_proxima_cita' readonly>";
            echo "</div>";
          echo "</div> ";
        }
        mysqli_free_result($resultado);
      }
      mysqli_next_result($conexion);
    }
  }


  $sentencia = "CALL sp_taservicio_listar($id_servicio);";
  if (mysqli_multi_query($conexion, $sentencia)) {
    if ($resultado = mysqli_store_result($conexion) ) {
      if ($fila = mysqli_fetch_row($resultado)) {
        $denominacion = $fila[0];
        $denominacion = utf8_encode($denominacion);
        $precio = $fila[1];
      }
      mysqli_free_result($resultado);
    }
    mysqli_next_result($conexion);
  }

  echo "<input type='hidden' class='form-control' id='txtservicio' name='txtservicio' value='$id_servicio'>";

  echo "<div class='form-group'>";
    echo "<label class='col-sm-2 control-label'>Servicio:</label>";
    echo "<div class='col-sm-4'>";
      echo "<input type='text' class='form-control round-form' id='txtNombreEsp' name='txtNombreEsp' readonly value='$denominacion'></input>";
    echo "</div>";
  echo "</div>";

  if ($id_servicio == 19) {
    $sentencia = "CALL sp_taatencion_paquete_de_parto('$id_paciente');";
    if (mysqli_multi_query($conexion, $sentencia)) {
      if ($resultado = mysqli_store_result($conexion)) {
        echo "<h5><i class='fa fa-angle-right'></i> Pagos realizados por el paciente</h5>";
        echo "<table class='table table-hover table-striped'>";
          echo "<thead>";
            echo "<tr>";
            echo "<th>Nro. de paquete</th>";
            echo "<th>Fecha y hora</th>";
            echo "<th>Pago</th>";
            echo "</tr>";
          echo "</thead>";
        $pago_total = 0;
        $nro_paquete = 1;
        while ($fila = mysqli_fetch_array($resultado)) {
          $fecha = $fila[0];
          $pago = $fila[1];
          $pago_total += $pago;
          echo "<tr>";
            echo "<td>$nro_paquete</td>";
            echo "<td>$fecha</td>";
            echo "<td>$pago</td>";
          echo "</tr>";
          if ($pago_total == 1500) {
            $nro_paquete++;
          }
        }
        mysqli_free_result($resultado);
        echo "</table>";
      }
      mysqli_next_result($conexion);
    }
  }

  echo "<div class='form-group'>";
    echo "<label class='control-label col-lg-2'>Precio</label>";
    echo "<div class='col-lg-4'>";
      echo "<input type='text' class='form-control round-form right-align' id='txtprecio' name='txtprecio' ";
      if (intval($precio) == 0) {
        echo "value='$precio'>";
      } else {
        $precio = "S/. ".$precio;
        echo "readonly value='$precio'>";
      }
    echo "</div>";
    echo "<label class='control-label col-lg-2'>Descuento</label>";
    echo "<div class='col-lg-4'>";
      echo "<input type='text' class='form-control round-form right-align' id='txtdescuento' name='txtdescuento'>";
    echo "</div>";
  echo "</div>";
  echo "<div class='form-group'>";
    echo "<label class='control-label col-lg-2 col-lg-offset-6'>TOTAL</label>";
    echo "<div class='col-lg-4'>";
      echo "<input type='text' class='form-control round-form right-align' readonly id='txtpago' name='txtpago'>";
    echo "</div>";
  echo "</div>";
  echo "<button class='btn btn-block btn-primary'><i class='fa fa-check'></i> Guardar</button>";
?>