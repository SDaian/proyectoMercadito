<!DOCTYPE html>
<html>
<head>
<style >
  #nameerror{
    display: none;
  }
</style>

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
  <?php
require_once 'sistema/controladorBD.php';

session_start();
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

if (isset($_GET['logout'])) {
    \sistema\controladorBD::logout();
  header('Location: login.php');
        die();
}
$cat = \sistema\controladorBD::allCategory();

if(isset($_GET['deleteproduct'])){
  \sistema\controladorBD::deleteProducto($_GET['deleteproduct']);
  header('Location: backend.php');
}
if(isset($_GET['deletecategory'])){
  $result = \sistema\controladorBD::deleteCategoria($_GET['deletecategory']);
if($result == false)
    {
      echo "<style>
              #nameerror{
                  display:block;
              }
           </style>";
    }
    else{
      header('Location: backend.php');
    }
}


$pro =  \sistema\controladorBD::getProductoByUserId($_SESSION['id']);
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
          <?php if (!isset($_SESSION['id'])) echo "
            <ul class='nav navbar-nav navbar-right'>
              <li class><a href='login.php'>Iniciar Sesion</a></li>
              <li class><a href='register.php'>¡Registrarme!</a></li>
            </ul>";
          else{
            echo "
            <ul class='nav navbar-nav navbar-right'>
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
                      <strong><span class="glyphicon glyphicon-ok"></span> Ud no puede borrar esta categoria porque esta asociada a un producto.</strong>
                  </div>
              </div>
      </div>
      <div class="row">
      <?php $u = new \clases\usuario();
          $u = \sistema\controladorBD::datosUsuario($_SESSION['id']);
       ?>
          <h2>¡Bienvenido, <span><?php echo $u->getNombre();?>! </span></h2>
          <div class="buttons-create">
            <a class="btn btn-info" href="newProduct.php" role="button">Crear articulo</a>
            <a class="btn btn-info" href="newCategory.php" role="button">Crear categoria</a>
          </div>
          </div>
           <div class="row">
           <h3>Mis productos</h3>
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoria</th>
            <th>Precio</th>
            <th>Caduca</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    
    <tbody>
      <?php
       foreach ($pro as $key) {?>
          <tr>
            <td><?php echo $key->getId(); ?></td>
            <td><?php echo $key->getNombre(); ?></td>
            <td><?php echo \sistema\controladorBD::getCategory($key->getIdCategoria()); ?></td>
            <td><?php echo $key->getPrecio(); ?></td>
            <td><?php echo $key->getCaducidad();?></td>
            <td><a href="editProduct.php?id=<?php echo $key->getId();?>" class="btn btn-info" role="button">Editar</a></td>
            <td><a href="backend.php?deleteproduct=<?php echo $key->getId(); ?>" onClick="return confirm('¿Confirma que desea borrar?')" class="btn btn-danger" role="button">Eliminar</a></td>
          </tr>
      <?php } ?>
    </tbody>
</table>
      </div>
      <div class="row">
           <h3>Categorias</h3>
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    
    <tbody>
      <?php
       foreach ($cat as $key) {?>
          <tr>
            <td><?php echo $key->getId(); ?></td>
            <td><?php echo $key->getNombre(); ?></td>
            <td><a href="editCategory.php?id=<?php echo $key->getId();?>" class="btn btn-info" role="button">Editar</a></td>
            <td><a href="backend.php?deletecategory=<?php echo $key->getId(); ?>" onClick="return confirm('¿Confirma que desea borrar?')" class="btn btn-danger" role="button">Eliminar</a></td>
          </tr>
      <?php } ?>
    </tbody>
</table>
      </div>
    </div>

</body>
</html>