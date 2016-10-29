<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "components.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('doctor');
  // Recuperamos el DNI del Usuario
  $User = $_SESSION["UsuarioLogueado"];
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Recuperamos valores enviados por GET
  $nro_atencion = $_GET["nroatencion"];
  $id_servicio = $_GET["idservicio"];
  $id_paciente = $_GET["idpaciente"];
  /*
    Para el siguiente paso consultamos si la atencion es Consulta o Procedimiento,
    ya que se procede de diferente manera para cada una
  */
  $sentencia = "CALL sp_taatencion_recuperar_servicio($nro_atencion)";
  if (mysqli_multi_query($conexion, $sentencia)) {
    if ($resultado = mysqli_store_result($conexion)) {
      if ($fila = mysqli_fetch_array($resultado)) {
        $tipo = $fila["vch_tipo"];
      }
      mysqli_free_result($resultado);
    }
    mysqli_next_result($conexion);
  }
?>
<?php if ($tipo == "Consulta"): ?>
<!DOCTYPE HTML>
<html>
  <head>
    <!-- General -->
    <title>Atención de Paciente | Clínica Mamá Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- Estilos CSS -->
    <link href="assets/css/style-menu-doctor.css" rel='stylesheet' type='text/css' />
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet"/>
    <link href="../assets/css/style-responsive.css" rel="stylesheet"/>
    <link href="assets/css/table-responsive.css" rel="stylesheet">
    <link href="assets/js/jquery-ui/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/layout.css">
  </head>
  <body>
    <div class="bg">
      <div class="container">
        <a value="Default Message" class="myButton" id="default" href="index.php">
          <div class="banner-grid banner-grid-active text-center">
            <span class="top-icon1"> </span>
            <h3>Página Principal</h3>
          </div>
        </a>
        <a value="Default Message" class="myButton" id="default" href="edit.php">
          <div class="banner-grid text-center">
            <span class="top-icon2"> </span>
            <h3>Actualizar mis datos</h3>
          </div>
        </a>
        <a value="Default Message" class="myButton" id="default" href="../logout.php">
          <div class="banner-grid text-center">
            <span class="top-icon3"> </span>
            <h3>Cerrar Sesión</h3>
          </div>
        </a>
      </div>
      <div class="container">
        <div class="row mt">
          <div class="col-lg-12">
            <div class="form-panel">
              <h3><i class="fa fa-angle-double-right"></i> Datos del Paciente</h3>
              <?php
                _print_datos_paciente($conexion, $nro_atencion);
              ?>

            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="form-panel">
              <h3>&nbsp;<i class="fa fa-angle-double-right"></i> Antecedentes del Paciente<i class="fa fa-minus pull-right" id="toggleAntecedentes"></i></h3>
              <?php
                _print_antecedentes($conexion, $nro_atencion, $id_servicio, $id_paciente);
              ?>

            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="form-panel">
              <h3>&nbsp;<i class="fa fa-angle-double-right"></i> Historia Clínica <i id="toggleHistorial" class="fa fa-minus pull-right"></i></h3>
              <?php
                _print_historial_paciente($conexion, $id_paciente);
              ?>

            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="form-panel">
              <h3>&nbsp;<i class="fa fa-angle-double-right"></i> Atención de hoy</h3>
              <form class="form-horizontal style-form" method="POST" action="guardar-consulta-paciente.php">
                <input type='hidden' class='form-control' name='DNI' id='DNI' value='<?=$id_paciente?>'>
                <input type='hidden' class='form-control' name='nroAtencion' id='nroAtencion' value='<?=$nro_atencion?>'>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Diagnóstico</label>
                  <div class="col-sm-10">
                    <textarea id="txtDiagnostico" name="txtDiagnostico" rows="4" class="form-control" required></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Tratamiento</label>
                  <div class="col-sm-10">
                    <textarea id="txtTratamiento" name="txtTratamiento" rows="4" class="form-control" required></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Próxima Cita</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtCita" name="txtCita">
                  </div>
                </div>
                <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-check"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
      _print_footer();
    ?>
    <script src="assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/ie-emulation-modes-warning.js"></script>
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="assets/js/jquery-ui/jquery-ui.js"></script>
    <script src="assets/js/atencion.js"></script>
    <script>
      $(document).ready(function () {
        $( "#FUR" ).datepicker({ dateFormat: "yy-mm-dd" });
        $( "#FUM" ).datepicker({ dateFormat: "yy-mm-dd" });
        $( "#FUR2" ).datepicker({ dateFormat: "yy-mm-dd" });
        $( "#FUM2" ).datepicker({ dateFormat: "yy-mm-dd" });
        $( "#txtCita" ).datepicker({ dateFormat: "yy-mm-dd" });
      });
    </script>
  </body>
</html>
<?php endif; ?>
<?php if ($tipo == "Procedimiento"): ?>
<?php
  $sentencia = "CALL sp_taatencion_atender_procedimiento($nro_atencion, '$User')";
  if (mysqli_multi_query($conexion, $sentencia)) {
    header("Location: confirmacion.php");
    exit;
  }
?>
<?php endif; ?>