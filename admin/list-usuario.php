<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "components.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('admin');
  // Recuperamos el id/dni del usuario
  $DNI = $_GET["chr_dni_usuario"];
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $Consulta = "CALL sp_tausuario_existe_new('".$DNI."')";
  if (mysqli_multi_query($conexion, $Consulta)) {
    if ($Resultado = mysqli_store_result($conexion)) {
      // Recuperar los daots del usuario
      $Fila = mysqli_fetch_array($Resultado);
      $Nombres=$Fila["vch_nombres"];
      $Nombres = utf8_encode($Nombres);
      $Apellidos = $Fila["vch_apellidos"];
      $Apellidos = utf8_encode($Apellidos);
      $Telefono=$Fila["vch_telefono"];
      $Domicilio=$Fila["vch_domicilio"];
      $Domicilio = utf8_encode($Domicilio);
      $Email = $Fila["vch_email"];
      $FNac = $Fila["dat_fecha_nacimiento"];
      $Sexo = $Fila["chr_sexo"];
      $Clave = $Fila["vch_clave"];
      $Clave = utf8_encode($Clave);
      $Rol = $Fila["vch_tipo_usuario"];
      $Esp1 = $Fila['vch_especialidad1'];
      $Esp2 = $Fila['vch_especialidad2'];
      $Estado = $Fila['vch_estado'];
      mysqli_free_result($Resultado);
    }
    mysqli_next_result($conexion);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- General -->
    <meta charset="utf-8">
    <title>Administrar Usuarios | Administrador </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/layout.css">
    <!-- Javascripts -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <!-- Cuerpo de la página -->
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
          <!-- BASIC FORM ELELEMNTS -->
          <div class="row mt">
            <div class="col-lg-6 col-sm-8">
              <div class="form-panel">
                <h3><i class="fa fa-angle-double-right"></i> Administrar Usuarios</h3>
                <h4 class="mb"><i class="fa fa-angle-double-right"></i> Datos del Usuario</h4>
                <table class="table table-striped table-condensed table-hover cf">
                  <tr>
                    <td ><b>DNI</b></td>
                    <td><?=$DNI?></td>
                  </tr>
                  <tr>
                    <td ><b>Nombres</b></td>
                    <td><?=$Nombres?></td>
                  </tr>
                  <tr>
                    <td ><b>Apellidos</b></td>
                    <td><?=$Apellidos?></td>
                  </tr>
                  <tr>
                    <td ><b>Teléfono</b></td>
                    <td><?=$Telefono?></td>
                  </tr>
                  <tr>
                    <td ><b>Domicilio</b></td>
                    <td><?=$Domicilio?></td>
                  </tr>
                  <tr>
                    <td ><b>Email</b></td>
                    <td><?=$Email?></td>
                  </tr>
                  <tr>
                    <td ><b>F. Nacimiento</b></td>
                    <td><?=$FNac?></td>
                  </tr>
                  <tr>
                    <td ><b>Sexo</b></td>
                    <td><?=$Sexo?></td>
                  </tr>
                  <tr>
                    <td ><b>Clave</b></td>
                    <td><?=$Clave?></td>
                  </tr>
                  <tr>
                    <td ><b>Rol</b></td>
                    <td><?=$Rol?></td>
                  </tr>
                  <tr>
                    <td ><b>Primera Especialidad</b></td>
                    <td><?=$Esp1?></td>
                  </tr>
                  <tr>
                    <td ><b>Segunda Especialidad</b></td>
                    <td><?=$Esp2?></td>
                  </tr>
                  <tr>
                    <td ><b>Estado</b></td>
                    <td><?=$Estado?></td>
                  </tr>
                </table>
                <p><a href="administrar-usuarios.php" class="btn btn-primary btn-block"><i class="fa fa-user"></i> Ir al Menú</a></p>
              </div>
            </div>
          </div>
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
    <script type="application/javascript">
      $(document).ready(function () {
        $("#a_administrador").addClass("active");
      });
    </script>
  </body>
</html>