<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Llamado a las funciones del radiologo
  require_once "components.php";
  //inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('radiologo');
  $usuario = $_SESSION["UsuarioLogueado"];
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
  <title>Buscar Paciente | Clínica Mamá Canguro</title>
  <link href="../assets/css/bootstrap.css" rel="stylesheet">
  <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/style-responsive.css" rel="stylesheet">
  <link href="../assets/css/style-login.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">
  <link rel="stylesheet" href="../assets/js/jquery-ui.css">
  <link href="assets/css/style-menu-admin.css" rel='stylesheet' type='text/css' />
  <link href="assets/css/animate.css" rel="stylesheet" type="text/css" media="all">
  <link href="../assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/layout.css">
  <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <section id="container" >
    <!--menu start-->
    <div class="bg">
      <div class="container">
        <?php _print_menu(); ?>
      </div>
      <div class="container">
        <div class="row m-t-15">
          <div class="col-sm-12">
            <div class="panel panel-default">
              <div class="panel-heading">Pacientes de Radiología</div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover table-condensed" id="tabla-pacientes">
                    <thead>
                      <tr>
                        <th>DNI</th>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <th>Buscar Examenes</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $consulta = "CALL sp_radiologo_pacientes();";
                        if (mysqli_multi_query($conexion, $consulta)) {
                          if ($result = mysqli_store_result($conexion)) {
                            while ($row = mysqli_fetch_row($result)) {
                              $dni = $row[0];
                              $nombres = utf8_encode($row[1]);
                              $apellidos = utf8_encode($row[2]);
                              ?>
                      <tr>
                        <td><?=$dni?></td>
                        <td><?=$apellidos?></td>
                        <td><?=$nombres?></td>
                        <td>
                          <button class='btn btn-primary btn-buscar-paciente' data-dni="<?=$dni?>">Buscar</button>
                        </td>
                      </tr>
                              <?php
                            }
                            mysqli_free_result($result);
                          }
                          mysqli_next_result($conexion);
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default">
              <div class="panel-heading">Atenciones</div>
              <div class="panel-body">
                <div class="table-responsive">
                  <div id="tabla-atenciones">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--main content end-->
    <?php
      _print_footer();
    ?>
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="assets/js/jquery-1.12.4.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
  <script src="assets/js/wow.min.js"></script>
  <script type="text/javascript" src="assets/js/move-top.js"></script>
  <script type="text/javascript" src="assets/js/easing.js"></script>
  <script src="assets/js/dataTables/jquery.dataTables.js"></script>
  <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
  <!-- script src="../assets/js/lock.js"></script-->
  <script src="assets/js/buscar-paciente.js"></script>
  <script>
    new WOW().init();
  </script>
</body>
</html>