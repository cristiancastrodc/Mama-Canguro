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
  // Recuperamos el DNI del usuario
  $User = $_SESSION["UsuarioLogueado"];
  //Recuperar la informacion del usuario
  $DNI = $_POST["txtId"];
  $Nombres = $_POST['txtNombres'];
  $AP = $_POST['txtAP'];
  $Telefono = $_POST['txtTelf'];
  $Dom = $_POST['txtDomi'];
  $Email = $_POST['txtCorreo'];
  $dia = $_POST['txtDia'];
  $mes = $_POST['txtMes'];
  $year = $_POST['txtYear'];
  $Fecha = $year."-".$mes."-".$dia;
  $Sexo = $_POST['txtSexo'];
  $Clave = $_POST['txtPass'];
  $Rol = $_POST['txtTipo'];
  $Esp1 = $_POST['txtEsp1'];
  $Esp2 = $_POST['txtEsp2'];
  $Estado = $_POST['txtEstado'];
  $Consulta ="CALL sp_tausuario_actualizar_admin('".$DNI."','".utf8_decode($Nombres)."','".utf8_decode($AP)."',
            '".utf8_decode($Telefono)."','".utf8_decode($Dom)."','".utf8_decode($Email)."',
            '".utf8_decode($Fecha)."','".utf8_decode($Sexo)."','".utf8_decode($Clave)."','".utf8_decode($Rol)."',
            '".utf8_decode($Esp1)."','".utf8_decode($Esp2)."','".utf8_decode($Estado)."');";
  mysqli_multi_query($conexion, $Consulta);
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- General -->
    <meta charset="utf-8">
    <title>Administrar Usuarios - Clínica Mamá Canguro</title>
    <link rel="icon" type="image/png" href="../assets/img/icon.ico"/>
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/table-responsive.css" rel="stylesheet">
    <link href="assets/css/layout.css" rel="stylesheet">
    <!-- Javascripts -->
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
                <h4 class="mb"><i class="fa fa-angle-right"></i> Datos Actualizados del Usuario</h4>
                <section id="no-more-tables">
                  <table class="table table-striped table-condensed cf">
                    <tr>
                      <td><b>DNI</b></td>
                      <td><?=$DNI?></td>
                    </tr>
                    <tr>
                      <td><b>Nombres</b></td>
                      <td><?=$Nombres?></td>
                    </tr>
                    <tr>
                      <td><b>Apellidos</b></td>
                      <td><?=$AP?></td>
                    </tr>
                    <tr>
                      <td><b>Teléfono</b></td>
                      <td><?=$Telefono?></td>
                    </tr>
                    <tr>
                      <td><b>Domicilio</b></td>
                      <td><?=$Dom?></td>
                    </tr>
                    <tr>
                      <td><b>Email</b></td>
                      <td><?=$Email?></td>
                    </tr>
                    <tr>
                      <td><b>Fecha de Nacimiento</b></td>
                      <td><?=$Fecha?></td>
                    </tr>
                    <tr>
                      <td><b>Sexo</b></td>
                      <td><?=$Sexo?></td>
                    </tr>
                    <tr>
                      <td><b>Clave</b></td>
                      <td><?=$Clave?></td>
                    </tr>
                    <tr>
                      <td><b>Rol</b></td>
                      <td><?=$Rol?></td>
                    </tr>
                    <tr>
                      <td><b>Primera Especialidad</b></td>
                      <td><?=$Esp1?></td>
                    </tr>
                    <tr>
                      <td><b>Segunda Especialidad</b></td>
                      <td><?=$Esp2?></td>
                    </tr>
                    <tr>
                      <td><b>Estado</b></td>
                      <td><?=$Estado?></td>
                    </tr>
                  </table>
                </section>
                <p><a href="administrar-usuarios.php" class="btn btn-primary btn-block"><i class="fa fa-user"></i> Ir al Menú</a> </p>
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
    <script>
      $(document).ready(function () {
        $("#a_administrador").addClass("active");
      });
    </script>
  </body>
</html>