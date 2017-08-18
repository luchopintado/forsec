<?php 
session_start();
require './config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="LP">
  <link rel="shortcut icon" href="favicon.png">

  <title>Login | <?php echo PAGE_TITLE; ?></title>

  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/signin.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
      <![endif]-->
    </head>

    <body>

      <div class="container">

        <div class="panel panel-primary panel-signin">
          <div class="panel-heading"><h3 class="panel-title"><strong>Inicio de Sesión </strong></h3></div>
          <div class="panel-body">
            <?php if(isset($_SESSION["error_message"])): ?>
              <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $_SESSION["error_message"]; ?>
              </div>
            <?php endif; ?>
           <form role="form" action="inicio.php?option=login" method="post">
            <div class="form-group">
              <label for="exampleInputEmail1">Nombre de Usuario</label>
              <input type="text" name="user" class="form-control" placeholder="Usuario" autofocus>              
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Contraseña <a href="inicio.php?option=forgot"><small>(olvidé la contraseña)</small></a></label>
              <input type="password" name="pass" class="form-control" placeholder="Contrase&ntilde;a">
            </div>
            <div class="form-group">
              <label class="checkbox">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value="remember-me"> Recordarme
              </label>              
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Iniciar Sesi&oacute;n</button>
          </form>
        </div>
      </div>
       
      </div> <!-- /container -->
    
  </body>
  </html>
