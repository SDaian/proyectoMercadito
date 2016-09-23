<!DOCTYPE html>
<html>
<head>
<style>
  #nameerror{
         display: none;
        }
  #nameerrortwo{
    display: none;
  }
  #namegood{
    display: none;
  }
</style>
<script type="text/javascript" src="js/validarRegistro.js"></script>
<?php
require_once 'sistema/controladorBD.php';

session_start();

if (isset($_GET['logout'])) {
    \sistema\controladorBD::logout();
  header('Location: login.php');
        die();
}
try{
  \sistema\controladorBD::usuarioLogueado();
  
}catch(Exception $e) {
  $mensaje=$e->getMessage();
  ?>
  <script>
    alert('<?php echo $mensaje ?>');
    window.location.href='login.php';
  </script>
  <?php
}

if(isset($_GET['id'])){
  $cat = \sistema\controladorBD::getCategory($_GET['id']);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   if((!empty($_POST['nombrecategoria']))){
    if (isset($_POST['nombrecategoria'])) {
        if (\sistema\controladorBD::comprobarCategoria($_POST['nombrecategoria']) != null) {
          $categoria = \sistema\controladorBD::updateCategoria($_POST['nombrecategoria'],$_GET['id']);
          $cat = \sistema\controladorBD::getCategory($_GET['id']);
          if ($categoria == null) {
              echo "<style>
              #nameerrortwo{
                  display:block;
              }
           </style>";
          }
          if($categoria== true){
          echo "<style>
              #namegood{
                  display:block;
              }
           </style>";
        }
        }
        else{
          echo "<style>
              #nameerror{
                  display:block;
              }
           </style>";
        }
        
    }
}
else{
  if (empty($_POST['nombrecategoria'])) {
            echo "ERROR: Debe completar el nombre. </br>";
        }
}

}

?>
	<meta charset="UTF-8">
	<title>Backend :: Mercadito</title>
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
          <?php if (!isset($_SESSION['id'])) echo "
            <ul class='nav navbar-nav navbar-right'>
              <li class><a href='login.php'>Iniciar Sesion</a></li>
              <li class><a href='register.php'>¡Registrarme!</a></li>
            </ul>";
          else{
            echo "
            <ul class='nav navbar-nav navbar-right'>
              <li class><a href='backend.php'>Backend</a></li>
              <li class><a href='editPerfil.php'>Editar Perfil</a></li>
              <li class><a href='login.php?logout'>Logout</a></li>
            </ul>";
          }
          ?>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
    <div class="col-lg-5 col-md-push-1">
              <div class="col-md-12">
                  <div class="alert alert-danger" id="nameerror">
                      <strong><span class="glyphicon glyphicon-ok"></span> Error! La categoria ya existe.</strong>
                  </div>
                  <div class="alert alert-danger" id="nameerrortwo">
                      <strong><span class="glyphicon glyphicon-ok"></span> Error! Debe ingresar un nombre valido.</strong>
                  </div>
                  <div class="alert alert-success" id="namegood">
                      <strong><span class="glyphicon glyphicon-ok"></span> Categoria actualizada!.</strong>
                  </div>
              </div>
      </div>
      <div class="row">
          <div class="loginContainer">
          <form method="post" action="" onSubmit="return validarCategoria()" role="login" name="formcategoria">
            <input type="text" name="nombrecategoria" placeholder="Ingrese nueva categoria" value="<?php echo $cat;?>" class="form-control input-lg">
            <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Crear categoria</button>
          </form>
      </div>
      </div>
    </div>

</body>
</html>