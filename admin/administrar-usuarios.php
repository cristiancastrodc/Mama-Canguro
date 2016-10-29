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
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- General -->
    <meta charset="utf-8">
    <title>Administrar Usuarios - Clínica Mamá Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico"/>
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">
    <link rel="stylesheet" href="assets/css/layout.css">
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
          <div class="row mt">
            <div class="col-lg-12">
              <!-- Formulario Nuevo Usuario-->
              <div class="form-panel">
                <h3>&nbsp;<i class="fa fa-angle-double-right"></i> Administrar Usuarios</h3>
                <h4 class="mb"><i class="fa fa-angle-double-right"></i> Ingresar Nuevo Usuario<i class="fa fa-minus pull-right" id='toggleNuevoUsuario'></i></h4>
                <div id="divNuevoUsuario">
                  <form id="form1" class="form-horizontal style-form" method="post" action="insertar-usuarios.php" onsubmit="return validarForm()">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">DNI</label>
                      <div class="col-sm-4">
                        <input maxlength="8" type="text" class="form-control" name="txtId" id="txtId" required autofocus>
                      </div>
                      <label class="col-sm-2 control-label">F. Nacimiento</label>
                      <div class="col-sm-1">
                        <input type="number" min="1" max="31" placeholder="dd" class="form-control" name="txtDia" id="txtDia" required>
                      </div>
                      <div class="col-sm-1">
                        <input type="number" min="1" max="12" placeholder="mm" class="form-control" name="txtMes" id="txtMes" required>
                      </div>
                      <div class="col-sm-2">
                        <input type="number" min="1900" placeholder="yyyy" class="form-control" name="txtYear" id="txtYear" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nombres</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="txtNombres" id="txtNombres" required>
                      </div>
                      <label class="col-sm-2 control-label">Apellidos</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="txtAP" id="txtAP" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Teléfono</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="txtTelf" id="txtTelf" required>
                      </div>
                      <label class="col-sm-2 control-label">Domicilio</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="txtDomi" id="txtDomi" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Correo</label>
                      <div class="col-sm-4">
                        <input placeholder="example@gmail.com" type="email" class="form-control" name="txtCorreo" id="txtCorreo">
                      </div>
                      <label class="col-sm-2 control-label">Sexo</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="txtSexo" id="txtSexo" required>
                          <option>M</option>
                          <option>F</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Rol</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="txtTipo" id="txtTipo" required>
                          <option>admin</option>
                          <option>biologo</option>
                          <option>secretaria</option>
                          <option>doctor</option>
                        </select>
                      </div>
                    </div>
                    <div id="especialidades">
                      <div class="form-group">
                        <label id="labelEsp1" class="col-sm-2 control-label">Primera Especialidad</label>
                        <div class="col-sm-4">
                          <select class="form-control" name="txtEsp1" id="txtEsp1">
                            <option>Medicina General</option>
                            <option>Ginecologia</option>
                            <option>Pediatria</option>
                          </select>
                        </div>
                        <label id="labelEsp2" class="col-sm-2 control-label">Segunda Especialidad</label>
                        <div class="col-sm-4">
                          <select class="form-control" name="txtEsp2" id="txtEsp2">
                            <option></option>
                            <option>Medicina General</option>
                            <option>Ginecologia</option>
                            <option>Pediatria</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Estado</label>
                      <div class="col-sm-4">
                        <select class="form-control" name="txtEstado" id="txtEstado" required>
                          <option>Habilitado</option>
                          <option>Deshabilitado</option>
                        </select>
                      </div>
                      <label class="col-sm-2 control-label">Clave Personal</label>
                      <div class="col-sm-4">
                        <input type="password" class="form-control" name="txtPass" id="txtPass" required>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check"></i> Crear Usuario</button>
                  </form>
                </div>
              </div>
            </div><!-- end col-lg-12 -->
          </div><!-- end row -->
          <div class="row mt">
            <div class="col-md-12">
              <div class="content-panel">
                <h3>&nbsp;<i class="fa fa-angle-double-right"></i> Lista de Usuarios</h3>
                <?php
                  _print_lista_usuarios($conexion);
                ?>
              </div><!-- /content-panel -->
            </div><!-- /col-md-12 -->
          </div><!-- /row -->
        </section><!-- /wrapper -->
      </section><!-- /MAIN CONTENT -->
      <!--footer start-->
      <?php
        _print_footer();
      ?>
    </section> <!-- Fin del cuerpo de la página -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/common-scripts.js"></script>
    <script src="../assets/js/lock.js"></script>
    <script>
      $(document).ready(function () {
        $("#toggleNuevoUsuario").click(function () {
          $("#divNuevoUsuario").slideToggle();
        });
        $("#especialidades").css("display", "none");
        $("#txtTipo").change(function() {
          var tipo = $('#txtTipo').val();
            if (tipo == "admin" || tipo == "biologo" || tipo == "secretaria") {
              $("#especialidades").slideUp("fast");
            }
            else{
              $("#especialidades").slideDown("fast");
            }
        });
        $("#a_administrador").addClass("active");
      });

      function validarForm () {
        var dni = $("#txtId").val();
        if (dni.length < 8) {
          alert('El campo DNI debe contener 8 caracteres.');
          return false;
        } else{
          document.form1.submit();
        }
      }
    </script>
  </body>
</html>