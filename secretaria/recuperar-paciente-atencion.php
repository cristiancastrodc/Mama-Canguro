<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
  // DNI del paciente
  $dni = $_GET["dni"];
  // id del servicio o consulta en otro caso
  $servicio = $_GET["servicio"];
  // No conectamos a la Base de datos a menos que el DNI tenga 8 caracteres
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Sentencia para recuperar los datos de un paciente utilizando su DNI
  $sentencia ="CALL sp_tapaciente_listar('$dni')";
  if (mysqli_multi_query($conexion, $sentencia)) {
    if ($resultado = mysqli_store_result($conexion)) {
      $cuenta = mysqli_num_rows($resultado);
      // Si existe ese paciente con ese DNI
      if ($cuenta == 1) {
        $paciente = mysqli_fetch_array($resultado);
        // Recuperamos nombres, apellidos e identificador del paciente
        $nombres = $paciente["vch_nombres"];
        $apellidos = $paciente["vch_apellidos"];
        $identificador = $paciente["chr_dni_paciente"];
        mysqli_free_result($resultado);
        mysqli_next_result($conexion);
        $nombre_completo = utf8_encode($nombres.' '.$apellidos);
        // Almacenamos el valor del identificador del paciente en un campo oculto para poder enviarlo mediante POST
        echo "<input type='hidden' value='$identificador' id='txtidentificador' name='txtidentificador'></input>";
        echo "<h4 class='mb'><i class='fa fa-angle-right'></i> Atención Paciente</h4>";
        echo "<div class='form-group'>";
          echo "<label class='col-lg-2 control-label'>Nombre del Paciente:</label>";
          echo "<div class='col-lg-4'>";
            echo "<input type='text' class='form-control round-form' id='txtnombre' name='txtnombre' value='$nombre_completo' readonly></input>";
          echo "</div>";
        echo "</div>";
        echo "<div class='form-group'>";
        // Sentencia para listar las características de un servicio
        $sentencia = "CALL sp_taservicio_listar('$servicio')";
        if (mysqli_multi_query($conexion, $sentencia)) {
          if ($resultado = mysqli_store_result($conexion)) {
            if ($fila = mysqli_fetch_array($resultado)) {
              $denominacion = $fila[0];
              $precio = $fila[1];
            }
          }
        }
        echo "<label class='col-lg-2 control-label'>Especialidad de:</label>";
        echo "<div class='col-lg-4'>";
          echo "<input type='text' class='form-control round-form uppercase' id='txtespecialidad' name='txtespecialidad' readonly value='$denominacion'></input>";
        echo "</div>";
        echo "<label class='col-lg-2 control-label'>Precio:</label>";
        echo "<div class='col-lg-4'>";
          echo "<input type='text' class='form-control round-form right-align' id='txtprecio' name='txtprecio' readonly value='S/. $precio'></input>";
        echo "</div>";
        echo "</div>";
        echo "<div class='form-group'>";
          echo "<label class='col-lg-2 control-label'>Descuento:</label>";
          echo "<div class='col-lg-4'>";
            echo "<input type='text' class='form-control round-form right-align' id='txtdescuento' name='txtdescuento'></input>";
          echo "</div>";
          echo "<label class='col-lg-2 control-label'>Total:</label>";
          echo "<div class='col-lg-4'>";
            echo "<input type='text' class='form-control round-form right-align' id='txtpago' name='txtpago' readonly value='S/. $precio'></input>";
          echo "</div>";
        echo "</div>";
        echo "<button type='submit' class='btn btn-block btn-lg btn-success' accesskey='e'>ENVIAR PACIENTE (Alt + E)</button>";
      }
      else{
        echo "<div class='alert alert-danger center-align'><b>Paciente no registrado! Por favor, previamente registre los datos del paciente.</b></div>"."<a href='filiacion.php' role='button' class='btn btn-primary btn-lg btn-block' accesskey='r'>Registrar al paciente (Alt + R)</a>";
      }
    }
  }
?>