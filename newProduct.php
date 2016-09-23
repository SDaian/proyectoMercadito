<!DOCTYPE html>
<html>
<head>
<style>
  #sqlerror{
         display: none;
        }
  #success{
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

if (isset($_POST['submit'])) {
   if((!empty($_POST['nombre'])) && (!empty($_POST['descripcion'])) && (!empty($_POST['precio'])) && ($_FILES['imagen']['size'] != 0)){
        $pic_dir = '';
        $pic_dir = '';
        if ($_FILES['imagen']['size'] != 0) {
            if (!($_FILES['imagen']['error'] > 0)) {
                $allowed_exts = array("gif", "jpeg", "jpg", "png");
                $temp = explode(".", $_FILES['imagen']['name']);
                $extension = end($temp);
                $pic_dir = '';
                 
                 
                $image= addslashes($_FILES['imagen']['tmp_name']);
                $name= addslashes($_FILES['imagen']['name']);
                 
                 $imgData =addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
                  $imageProperties = getimageSize($_FILES['imagen']['tmp_name']);
 
                if ((($_FILES['imagen']['type'] == "image/gif")
                        || ($_FILES['imagen']['type'] == "image/jpeg")
                        || ($_FILES['imagen']['type'] == "image/jpg")
                        || ($_FILES['imagen']['type'] == "image/pjpeg")
                        || ($_FILES['imagen']['type'] == "image/x-png")
                        || ($_FILES['imagen']['type'] == "image/png"))
                        && ($_FILES['imagen']['size'] < 10485760)
                        && in_array($extension, $allowed_exts)) {
 
        //este es el archivo temporal
         $imagen_temporal  = $_FILES['imagen']['tmp_name'];
    //este es el tipo de archivo
          $tipo = $_FILES['imagen']['type'];
    //leer el archivo temporal en binario
                $fp     = fopen($imagen_temporal, 'r+b');
                $data = fread($fp, filesize($imagen_temporal));
                fclose($fp);

                } else {
                    die("ERROR: TIPO/TAMAÑO DE IMAGEN INVALIDO: " . $_FILES['imagen']['type'] . " / " . $_FILES['imagen']['size']);
                }
            }
        }
         
        $category = $_POST['categoria'];
        $str=substr($category, 0, strrpos($category, ' '));


        $post = new \clases\producto();
        $post->setNombre($_POST['nombre']);
        $post->setDescripcion($_POST['descripcion']);
        $post->setPrecio($_POST['precio']);
        $post->setContenidoImagen($data);
        $post->setTipoImagen($tipo);
        $post->setIdCategoria($str);
        $post->setIdUsuario(\sistema\controladorBD::datosUsuario($_SESSION['id'])->getId());
        $today = date("Y-m-d");
        $postdate= date("Y-m-d", strtotime("+1 month", strtotime($today)));
        $post->setPublicacion($today);
        $post->setCaducidad($postdate);
        $sql = \sistema\controladorBD::crearProducto($post);
        if($sql){
            echo "<style>
                        #success{
                            display:block;
                        }
                     </style>";
        }else{
            echo "<style>
                        #sqlerror{
                            display:block;
                        }
                     </style>";
        }
    }else{
          if (empty($_POST['nombre'])) {
              echo "ERROR: Debe completar el nombre. </br>";
          }
          if (empty($_POST['descripcion'])) {
              echo "ERROR: Debe completar la descripcion. </br>";
          }
          if (empty($_POST['precio'])) {
              echo "ERROR: Debe completar el precio. </br>";
          }
          if (($_FILES['imagen']['size'] == 0)) {
              echo "ERROR: Debe subir una imagen. </br>";
          }
    }
}
$categorias = \sistema\controladorBD::allCategory();
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

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

  <!-- (Optional) Latest compiled and minified JavaScript translation files -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/i18n/defaults-*.min.js"></script>

	<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,300,600,700" rel="stylesheet" type="text/css">
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/style.css">
  <link href="favicon.ico" rel="icon" type="image/x-icon" />
  <script type="text/javascript" src="js/validarProducto.js"></script>
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
    <div class="row">
        <form role="form" name="registro" onSubmit="return validar()" enctype="multipart/form-data" action=""  method="POST">
            <div class="col-lg-6">
                <div class="well well-sm"><strong><span class="glyphicon glyphicon-asterisk"></span>Campos requeridos</strong></div>
                <div class="form-group">
                    <label for="InputNombre">Nombre</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="nombre" id="InputName" placeholder="Nombre del producto">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputDescripcion">Descripcion</label>
                    <div class="input-group">
                        <textarea class="form-control" id="InputDescripcion" name="descripcion" rows="3" placeholder="Breve descripcion del producto"></textarea>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="sala">Categoria</label>
                    <br/>
                            <select id ="categoria" name="categoria" class="selectpicker">
                  <?php
                    $auxsala1;
                    $i = 0;
                    foreach ($categorias as $s) {
                            echo "<option> ". $s->getId(). " - " . $s->getNombre()."</option>";}
                        ?>
                  </select>
                  
                </div>
                <div class="form-group">
                    <label for="InputPrecio">Precio</label>
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                        <input type="number" class="form-control" id="InputPrecio" name="precio" placeholder="Precio del producto">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                    </div>
                </div>
                <div class="form-group">
                  <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                <label for="imagen">Imagen</label>
                  <br/>
                <input type="file" id="imagen" name="imagen" onchange="return ValidateFileUpload()"/>
              </div>
              
                
                <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
            </div>
        </form>
        <div class="col-lg-5 col-md-push-1">
            <div class="col-md-12">
                <div class="alert alert-danger" id="sqlerror">
                    <strong><span class="glyphicon glyphicon-ok"></span> Ha ocurrido un error al ejecutar la consulta!</strong>
                </div>
                <div class="alert alert-success see" id="success">
                    <strong><span class="glyphicon glyphicon-ok"></span> Su producto ha sido registrado correctamente.</strong>
                </div>
                <div class="alert alert-danger" id="errorimagen" style="display: none;">
                    <span class="glyphicon glyphicon-remove"></span><strong> Error! Debe ingresar una imagen.</strong>
                </div>
                <div class="alert alert-danger" id="errordescripcion" style="display: none;">
                    <span class="glyphicon glyphicon-remove"></span><strong> Error! Debe ingresar una descripcion valida.</strong>
                </div>
                <div class="alert alert-danger" id="errorprecio" style="display: none;">
                    <span class="glyphicon glyphicon-remove"></span><strong> Error! Debe ingresar un precio valido.</strong>
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


</body>
</html>