<!DOCTYPE html>
<html>
<?php
require_once 'sistema/controladorBD.php';
  if(isset($_GET['id']) && !empty($_GET['id'])){
    $path = "mostrarImagen.php?id=";
    $e = new clases\producto();
    if(($e = sistema\controladorBD::getProductoById($_GET['id'])) != null){
      $pathc = \sistema\controladorBD::getCategory($e->getIdCategoria());
      $u = new clases\usuario();
      $u = \sistema\controladorBD::getUserById($e->getIdUsuario());
    }
    else header("Location: index.php");
  }
  else header("Location: index.php");

?>
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
            <li><a href="register.php">¡Registrarme!</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
        <div class="row">
          <h4><span class="label label-info"><?php echo $pathc ?></span></h4>
          <h2><?php echo $e->getNombre();?></h2>
          <p><?php echo $e->getDescripcion();?></p>
        </div>
        <div class="row">
          <div class="imagenp">
            <img src="<?php echo $path . $e->getId();?>" class="img-responsive" alt="Responsive image">
          </div>
          <div class="info">
              <h3><span class="label label-primary price">$<?php echo $e->getPrecio();?></span></h3>
              <h4>Dueño: <?php echo $u->getNombre() ." ".  $u->getApellido(); ?></h4>
              <h4>Email: <?php echo $u->getEmail() ;?></h4>
              <h4>Telefono: <?php echo $u->getTelefono() ; ?></h4>
          </div>
          <div class="info">
            <h4><span class="label label-info fecha">Valido desde: </span> <span class="fecha2"><?php echo $e->getPublicacion(); ?></span></h4>
            <h4><span class="label label-info fecha">Valido hasta: </span> <span class="fecha2"><?php echo $e->getCaducidad(); ?></span></h4>
          </div>
        </div>

    </div>
<?php include("footer.php"); ?>
</body>
</html>