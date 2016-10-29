<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('doctor');
  $User = $_SESSION["UsuarioLogueado"];
  $Enlace = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $Consulta= "CALL sp_tausuario_existe_new('".$User."')";
  $Resultado = mysqli_query($Enlace,$Consulta);

  // Recuperar los datos del usuario
  $Fila = mysqli_fetch_array($Resultado);

  $Nombres=$Fila["vch_nombres"];
  $Nombres = utf8_encode($Nombres);
  $Apellidos=$Fila["vch_apellidos"];
  $Apellidos = utf8_encode($Apellidos);
  $Telefono=$Fila["vch_telefono"];
  $Domicilio=$Fila["vch_domicilio"];
  $Domicilio = utf8_encode($Domicilio);
  $Email=$Fila["vch_email"];
  $Email = utf8_encode($Email);
  $FNac=$Fila["dat_fecha_nacimiento"];
  $FNac = strtotime($FNac);
  $dia_nacimiento = date('d', $FNac);
  $mes_nacimiento = date('m', $FNac);
  $year_nacimiento = date('Y', $FNac);
  $Sexo=$Fila["chr_sexo"];
  $Clave=$Fila["vch_clave"];
  $Clave = utf8_encode($Clave);
?>
<!DOCTYPE HTML>
<html>
  <head>
    <!-- General -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Actualizar Datos Personales | Mamá Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- Estilos CSS -->
    <link href="assets/css/style-menu-doctor.css" rel='stylesheet' type='text/css' />
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">
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
      <div class="banner-info">
        <div class="container site-min-height">
          <div class="row mt">
            <div class="col-lg-12">
              <div class="form-panel">
                <h3><i class="fa fa-angle-double-right"></i>Actualizar Mis Datos</h3>
                <form class="form-horizontal style-form" method="POST" action="edit-process.php">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">DNI</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="txtId" id="txtId" value="<?=$User?>" readonly required>
                    </div>
                    <label class="col-sm-2 control-label">Fecha de Nacimiento</label>
                    <div class="col-sm-1">
                      <input type="number" class="form-control" name="txtDia" id="txtDia" required placeholder="dd" value="<?=$dia_nacimiento?>">
                    </div>
                    <div class="col-sm-1">
                      <input type="number" class="form-control" name="txtMes" id="txtMes" required placeholder="mm" value="<?=$mes_nacimiento?>">
                    </div>
                    <div class="col-sm-2">
                      <input type="number" class="form-control" name="txtYear" id="txtYear" required placeholder="yyyy" value="<?=$year_nacimiento?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Nombres</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="txtNombres" id="txtNombres" value="<?=$Nombres?>" required autofocus>
                    </div>
                    <label class="col-sm-2 control-label">Apellidos</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="txtAP" id="txtAP" value="<?=$Apellidos?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Teléfono</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="txtTelf" id="txtTelf" value="<?=$Telefono?>" required>
                    </div>
                    <label class="col-sm-2 control-label">Domicilio</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="txtDomi" id="txtDomi" value="<?=$Domicilio?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Correo</label>
                    <div class="col-sm-4">
                      <input type="email" class="form-control" name="txtCorreo" id="txtCorreo" value="<?=$Email?>">
                    </div>
                    <label class="col-sm-2 control-label">Sexo</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="txtSexo" id="txtSexo" required>
                        <?php
                          if ($Sexo == "F") {
                            echo "<option>F</option>";
                            echo "<option>M</option>";
                          } else {
                            echo "<option>M</option>";
                            echo "<option>F</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Clave</label>
                    <div class="col-sm-4">
                      <input type="password" class="form-control" name="txtClave" id="txtClave" value="<?=$Clave?>" required>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check"></i> Actualizar</button>
                </form>
              </div>
            </div><!-- col-lg-12-->
          </div><!-- /row -->
        </div>
      </div>
    </div>
    <?php
      _print_footer();
    ?>
    <!-- Javascripts -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/lock.js"></script>
  </body>
</html>

