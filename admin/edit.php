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
  // Recuperamos el DNI del usuario a modificar
  $DNI = $_GET["chr_dni_usuario"];
  $Consulta = "CALL sp_tausuario_existe_new('".$DNI."')";
  if (mysqli_multi_query($conexion, $Consulta)) {
    if ($Resultado = mysqli_store_result($conexion)) {
      // Recuperar los datos del usuario
      $Fila = mysqli_fetch_array($Resultado);
      // Recuperar los datos individualmente
      $Nombres = $Fila["vch_nombres"];
      $Nombres = utf8_encode($Nombres);
      $Apellidos = $Fila["vch_apellidos"];
      $Apellidos = utf8_encode($Apellidos);
      $Telefono = $Fila["vch_telefono"];
      $Domicilio = $Fila["vch_domicilio"];
      $Domicilio = utf8_encode($Domicilio);
      $Email = $Fila["vch_email"];
      $FNac = $Fila["dat_fecha_nacimiento"];
      $FNac = strtotime($FNac);
      $dia_nacimiento = date('d', $FNac);
      $mes_nacimiento = date('m', $FNac);
      $year_nacimiento = date('Y', $FNac);
      $Sexo = $Fila["chr_sexo"];
      $Clave = $Fila["vch_clave"];
      $Clave = utf8_encode($Clave);
      $Rol = $Fila["vch_tipo_usuario"];
      $Esp1 = $Fila['vch_especialidad1'];
      $Esp2 = $Fila['vch_especialidad2'];
      $Estado = $Fila['vch_estado'];
    }
    mysqli_free_result($Resultado);
  }
  mysqli_next_result($conexion);
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
                <h3>&nbsp;<i class="fa fa-angle-double-right"></i> Actualizar Datos del Usuario</h3>
                <form id="form" class="form-horizontal style-form" method="post" action="edit-process.php">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">DNI</label>
                    <div class="col-sm-4">
                      <input maxlength="8" type="text" class="form-control" value="<?=$DNI?>" name="txtId" id="txtId" readonly required>
                    </div>
                    <label class="col-sm-2 control-label">Fecha de Nacimiento</label>
                    <div class="col-sm-1">
                      <input type="number" class="form-control" value="<?=$dia_nacimiento?>" name="txtDia" id="txtDia" required>
                    </div>
                    <div class="col-sm-1">
                      <input type="number" class="form-control" value="<?=$mes_nacimiento?>" name="txtMes" id="txtMes" required>
                    </div>
                    <div class="col-sm-2">
                      <input type="number" class="form-control" value="<?=$year_nacimiento?>" name="txtYear" id="txtYear" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Nombres</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="<?=$Nombres?>" name="txtNombres" id="txtNombres" required autofocus>
                    </div>
                    <label class="col-sm-2 control-label">Apellidos</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="<?=$Apellidos?>" name="txtAP" id="txtAP" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Teléfono</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="<?=$Telefono?>" name="txtTelf" id="txtTelf" required>
                    </div>
                    <label class="col-sm-2 control-label">Domicilio</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" value="<?=$Domicilio?>"name="txtDomi" id="txtDomi" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Correo</label>
                    <div class="col-sm-4">
                      <input type="email" class="form-control" value="<?=$Email?>" name="txtCorreo" id="txtCorreo">
                    </div>
                    <label class="col-sm-2 control-label">Sexo</label>
                    <div class="col-sm-4">
                      <select class="form-control" value="<?=$Sexo?>" name="txtSexo" id="txtSexo" required>
                        <?php
                          if ($Sexo == "M") {
                            echo "<option>M</option>";
                            echo "<option>F</option>";
                          }else{
                            echo "<option>F</option>";
                            echo "<option>M</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Rol</label>
                    <div class="col-sm-4">
                      <input readonly type="text" class="form-control" value="<?=$Rol?>" name="txtTipo" id="txtTipo">
                    </div>
                  </div>
                  <div class="form-group" id="especialidades">
                    <label class="col-sm-2 control-label">Primera Especialidad</label>
                    <div class="col-sm-4">
                      <input class="form-control" name="txtEsp1" id="txtEsp1" value="<?=$Esp1?>" readonly>
                    </div>
                    <label class="col-sm-2 control-label">Segunda Especialidad</label>
                    <div class="col-sm-4">
                      <input class="form-control" name="txtEsp2" id="txtEsp2" value="<?=$Esp2?>" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Estado</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="txtEstado" id="txtEstado" required>
                        <?php
                          $estados = array('Habilitado', 'Deshabilitado', 'En Sesion');
                          echo "<option value='$Estado'>$Estado</option>";
                          for ($i=0; $i < 3; $i++) {
                            if (!($Estado == $estados[$i])) {
                              echo "<option value='$estados[$i]'>$estados[$i]</option>";
                            }
                          }
                        ?>
                      </select>
                    </div>
                    <label class="col-sm-2 col-sm-2 control-label">Clave Personal</label>
                    <div class="col-sm-4">
                      <input type="password" class="form-control" name="txtPass" id="txtPass" value="<?=$Clave?>" required>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check"></i> Actualizar</button>
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
    <script>
      $(document).ready(function () {
        $("#a_administrador").addClass("active");
        var rol = $("#txtTipo").val();
        if (rol != 'doctor') {
          $("#especialidades").css("display", "none");
        }
      });
    </script>
  </body>
</html>