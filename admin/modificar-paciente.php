<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "components.php";
  // Inicializar la sesion
  if (!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('admin');
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Recuperamos el DNI del usuario a modificar
  $id_paciente = $_GET["idpaciente"];
  $sentencia = "CALL sp_tapaciente_listar_id('$id_paciente');";
  if (mysqli_multi_query($conexion, $sentencia)) {
    if ($resultado = mysqli_store_result($conexion)) {
      if ($paciente = mysqli_fetch_row($resultado)) {
        $nombres = $paciente[1];
        $nombres = utf8_encode($nombres);
        $apellidos = $paciente[2];
        $apellidos = utf8_encode($apellidos);
        $domicilio = $paciente[3];
        $domicilio = utf8_encode($domicilio);
        $fecha_nacimiento = $paciente[4];
        $fecha_nacimiento = strtotime($fecha_nacimiento);
        $dia_nacimiento = date('d', $fecha_nacimiento);
        $mes_nacimiento = date('m', $fecha_nacimiento);
        $year_nacimiento = date('Y', $fecha_nacimiento);
        $telefono = $paciente[5];
        $grado_instruccion = $paciente[6];
        $estado_civil = $paciente[7];
        $sexo = $paciente[8];
        $ocupacion = $paciente[9];
        $ocupacion = utf8_encode($ocupacion);
        $fecha_filiacion = $paciente[10];
        $dni = $paciente[11];
      }
      mysqli_free_result($resultado);
    }
    mysqli_next_result($conexion);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- General -->
    <meta charset="utf-8">
    <title>Modificar Datos de Paciente - Clínica Mamá Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico"/>
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/layout.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <!-- Javascripts -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <section id="container" >
      <?php
        // Mostrar el header
        _print_header();
        // Mostrar el menú
        _print_menu($conexion);
      ?>
      <!-- *******************************  MAIN CONTENT  ******************************************* -->
      <section id="main-content">
        <section class="wrapper">
          <!-- BASIC FORM ELEMENTS -->
          <div class="row mt">
            <div class="col-lg-12">
              <div class="form-panel">
                <h3>&nbsp;<i class="fa fa-angle-double-right"></i> Actualizar Datos del Paciente</h3>
                <form id="form" class="form-horizontal style-form" method="post" action="actualizar-datos-paciente.php">
                  <input type='hidden' id='txtIdPaciente' name='txtIdPaciente' value='<?=$id_paciente?>'>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">DNI</label>
                    <div class="col-sm-4">
                      <input maxlength="8" type="text" class="form-control" value="<?=$dni?>" name="txtDNI" id="txtDNI" required>
                    </div>
                    <label class="col-sm-2 control-label">Fecha de nacimiento</label>
                    <div class="col-sm-1">
                      <input type='number' class='form-control' id='txtDia' name='txtDia' placeholder='dd' value="<?=$dia_nacimiento?>" min="1" max="31">
                    </div>
                    <div class="col-sm-1">
                      <input type='number' class='form-control' id='txtMes' name='txtMes' placeholder='mm' value="<?=$mes_nacimiento?>" min="1" max="12">
                    </div>
                    <div class="col-sm-2">
                      <input type='number' class='form-control' id='txtYear' name='txtYear' placeholder='dd' value="<?=$year_nacimiento?>" min="1900">
                    </div>
                  </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label">Nombres</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="<?=$nombres?>" name="txtNombres" id="txtNombres" required>
                    </div>
                    <label class="col-sm-2 control-label">Apellidos</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="<?=$apellidos?>" name="txtApellidos" id="txtApellidos" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Domicilio</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="<?=$domicilio?>" name="txtDomicilio" id="txtDomicilio">
                    </div>
                    <label class="col-sm-2 control-label">Teléfono</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="<?=$telefono?>" name="txtTelefono" id="txtTelefono">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Sexo</label>
                    <div class="col-sm-4">
                      <select maxlength="1" class="form-control" value="<?=$sexo?>" name="txtSexo" id="txtSexo">
                        <?php
                          if ($sexo == "M") {
                            echo "<option>M</option>";
                            echo "<option>F</option>";
                          } else {
                            echo "<option>F</option>";
                            echo "<option>M</option>";
                          }
                        ?>
                      </select>
                    </div>
                    <label class="col-sm-2 control-label">Ocupación</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="<?=$ocupacion?>" name="txtOcupacion" id="txtOcupacion">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Grado de instrucción</label>
                    <div class="col-sm-4">
                      <select class='form-control' id='txtGrado' name='txtGrado'>
                        <?php
                          $grados = array('Ninguno', 'Primaria', 'Secundaria', 'Universitaria');
                          echo "<option>$grado_instruccion</option>";
                          for ($i=0; $i < 4; $i++) {
                            if ($grado_instruccion != $grados[$i]) {
                              echo "<option>$grados[$i]</option>";
                            }
                          }
                        ?>
                      </select>
                    </div>
                    <label class="col-sm-2 control-label">Estado civil</label>
                    <div class="col-sm-4">
                      <select class='form-control' id='txtEstado' name='txtEstado'>
                        <?php
                          $estados = array('Soltero(a)', 'Casado(a)', 'Conviviente', 'Viudo(a)', 'Divorciado(a)');
                          echo "<option>$estado_civil</option>";
                          for ($i=0; $i < 5; $i++) {
                            if ($estado_civil != $estados[$i]) {
                              echo "<option>$estados[$i]</option>";
                            }
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check"></i> Guardar</button>
                </form>
              </div>
            </div><!-- col-lg-12-->
          </div><!-- /row -->
        </section><!-- /wrapper -->
      </section><!-- /MAIN CONTENT -->
      <?php
        _print_footer();
      ?>
    </section> <!-- Fin del cuerpo de la página -->
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/common-scripts.js"></script>
    <script src="../assets/js/lock.js"></script>
    <script type="text/javascript">
      $(function() {
        $("#a_secretaria").addClass("active");
      });
    </script>
  </body>
</html>