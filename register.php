<!DOCTYPE html>
<html>

<head>
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
    <style>
        #success{
            display: none;
        }
        #emailerror{
            display: none;
        }

    </style>
  <script type="text/javascript">
      window.onload = function () {
      document.registro.InputName.focus();
      } 
  </script>
  <script type="text/javascript" src="js/validarRegistro.js"></script>
<?php
require_once 'sistema/controladorBD.php';
session_start();

if (isset($_SESSION['user'])) {
    header('Location: backend.php');
    die();
}

if(isset($_POST['submit'])) {
    if((!empty($_POST['nombre'])) && (!empty($_POST['apellido']))
        && (!empty($_POST['email'])) && (!empty($_POST['telefono']))
        && (!empty($_POST['passf'])) && (!empty($_POST['passs']))){

        $post = new \clases\usuario();

        $post->setNombre($_POST['nombre']);
        $post->setClave($_POST['passf']);
        $post->setApellido($_POST['apellido']);
        $post->setEmail($_POST['email']);
        $post->setTelefono($_POST['telefono']);
        try {
            if (\sistema\controladorBD::comprobarUsuario($_POST['email']) == null) {
                $sql = \sistema\controladorBD::crearUsuario($post);
                if($sql){
                    echo "<style>
                        #success{
                            display:block;
                        }
                     </style>";}
                }
                 else{
                    echo "<style>
                    #emailerror{
                        display:block;
                    }
                 </style>";;
                 }
         }catch (PDOException $e) {
            echo 'Could not connect : ' . $e->getMessage();
        }
    }
    else{
        if (empty($_POST['nombre'])) {
            echo "ERROR: Debe completar el nombre. </br>";
        }
        if (empty($_POST['apellido'])) {
            echo "ERROR: Debe completar el apellido.</br>";
        }
        if (empty($_POST['email'])) {
            echo "ERROR: Debe completar email.</br>";
        }
        if (empty($_POST['telefono'])) {
            echo "ERROR: Debe completar telefono.</br>";
        }
        if (empty($_POST['passf'])) {
            echo "ERROR: Debe completar contraseña.</br>";
        }
        if (empty($_POST['passs'])) {
            echo "ERROR: Debe confirmar la contraseña.</br>";
        }
        
    }
    }
?>
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
            <li class><a href="login.php">Iniciar Sesion</a></li>
            <li  class="active"><a href="#">¡Registrarme!</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<div class="container">
    <div class="row">
        <form role="form" name="registro" onSubmit="return validar()"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  method="POST">
            <div class="col-lg-6">
                <div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>Campos requeridos</strong></div>
                <div class="form-group">
                    <label for="InputNombre">Nombre</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="nombre" id="InputName" placeholder="Nombre">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputApellido">Apellido</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="InputApellido" name="apellido" placeholder="Apellido" >
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputEmail">Email</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="InputEmailFirst" name="email" placeholder="Email">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputTelefono">Telefono</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="InputTelefono" name="telefono" placeholder="Telefono">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputPasswordF">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="InputPasswordF" name="passf" placeholder="Password">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputPasswordS">Confirma Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="InputPasswordS" name="passs" placeholder="Confirma Password">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
            </div>
        </form>
        <div class="col-lg-5 col-md-push-1">
            <div class="col-md-12">
                <div class="alert alert-danger" id="emailerror">
                    <strong><span class="glyphicon glyphicon-ok"></span> Error! El email ya se encuentra registrado.</strong>
                </div>
                <div class="alert alert-success see" id="success">
                    <strong><span class="glyphicon glyphicon-ok"></span> Felicitaciones! Gracias por registrarse.</strong>
                </div>
                <div class="alert alert-danger" id="errornombre" style="display: none;">
                    <span class="glyphicon glyphicon-remove"></span><strong> Error! Debe ingresar un nombre valido.</strong>
                </div>
                <div class="alert alert-danger" id="errorapellido" style="display: none;">
                    <span class="glyphicon glyphicon-remove"></span><strong> Error! Debe ingresar un apellido valido.</strong>
                </div>
                <div class="alert alert-danger" id="erroremail" style="display: none;">
                    <span class="glyphicon glyphicon-remove"></span><strong> Error! Debe ingresar un email.</strong>
                </div>
                <div class="alert alert-danger" id="errorpass" style="display: none;">
                    <span class="glyphicon glyphicon-remove"></span><strong> Error! Debe ingresar un password.</strong>
                </div>
                <div class="alert alert-danger" id="errortelefono" style="display: none;">
                    <span class="glyphicon glyphicon-remove"></span><strong> Error! Debe ingresar un telefono.</strong>
                </div>
                 <div class="alert alert-danger" id="errorpassf" style="display: none;">
                    <span class="glyphicon glyphicon-remove"></span><strong> Error! Los passwords deben coincidir.</strong>
                </div>
            </div>
        </div>
    </div>
</div>
 <?php include("footer.php"); ?>
</body>
</html>