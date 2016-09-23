<!DOCTYPE html>
<html>
<head>
<style>
        #passerror{
            display: none;
        }
        #emailerror{
            display: none;
        }
        #logerror{
            display:none;
        }
        #logerrorpass{
          display: none;
        }
</style>
<?php
require_once 'sistema/controladorBD.php';

session_start();

if (isset($_GET['logout'])) {
    \sistema\controladorBD::logout();
  header('Location: login.php');
        die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $req = array( 'email', 'password');
  $status = true;
  foreach ($req as $field) {
      if (empty($_POST[$field])) {
          echo 'El campo ' . $field . ' esta vacio. Por favor completelo';
          $status = false;
      }
  }
    if (isset($_POST['email'], $_POST['password']) && ($status)) {
        if (\sistema\controladorBD::comprobarUsuario($_POST['email']) != null) {
            try {
             $user = \sistema\controladorBD::loginUsuario($_POST['email'], $_POST['password']);
             $_SESSION['id'] = $user->getId();
             echo $_SESSION['id'];
            }
            catch (Exception $e) {
              $mensaje = $e->getMessage();
              echo '<div class="col-md-5"><div class="alert alert-danger see">
                      <strong><span class="glyphicon glyphicon-ok"></span>'.$mensaje.'</strong>
                  </div></div>';
            }
        }
        else{
          echo "<style>
              #logerror{
                  display:block;
              }
           </style>";
        }
    }
}

if (isset($_SESSION['id'])) {
    header('Location: backend.php');
    die();
}
?>
	<meta charset="UTF-8">
	<title>Index :: Mercadito</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,300,600,700" rel="stylesheet" type="text/css">
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/style.css">
  <link href="favicon.ico" rel="icon" type="image/x-icon" />
  <script type="text/javascript" src="js/validarLogin.js"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Mercadito</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="register.php">Iniciar Sesion</a></li>
            <li><a href="register.php">¡Registrarme!</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
      <div class="col-lg-5 col-md-push-1">
              <div class="col-md-12">
                  <div class="alert alert-danger" id="emailerror">
                      <strong><span class="glyphicon glyphicon-ok"></span> Error! Debe ingresar un email.</strong>
                  </div>
                  <div class="alert alert-danger see" id="passerror">
                      <strong><span class="glyphicon glyphicon-ok"></span> Error! Debe ingresar una contraseña.</strong>
                  </div>
                  <div class="alert alert-danger see" id="logerrorpass">
                      <strong><span class="glyphicon glyphicon-ok"></span> Error! La contraseña ingresada es incorrecta.</strong>
                  </div>
                  <div class="alert alert-danger see" id="logerror">
                      <strong><span class="glyphicon glyphicon-ok"></span> Error! No hay ningun usuario registrado con este mail.</strong>
                  </div>
              </div>
      </div>
      <div class="loginContainer">
          <form method="post" action="" onSubmit="return validar()" role="login" name="registrologin">
            <input type="email" name="email" placeholder="Email"  class="form-control input-lg">
            <input type="password" name="password" placeholder="Password" class="form-control input-lg">
            <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Iniciar Sesion</button>
            <div>
              <a href="register.php">¡Registrate!</a>
            </div>
          </form>
      
      </div>
    </div>

</body>
</html>