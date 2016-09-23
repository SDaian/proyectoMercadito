<!DOCTYPE html>
<html>
<?php
  session_start();
  include_once('sistema/connection.php');
  require_once 'sistema/controladorBD.php';

$start=0;
$limit=1;
 
if(isset($_GET['page']))
{
    $id=$_GET['page'];
    $start=($id-1)*$limit;
}
else{
    $id=1;
}
  $filter= "";
    if(isset($_GET['query']) && (!empty($_GET['query']))){
      $filter .= "AND nombre LIKE '%".$_GET['query']."%'";
    }
    if(isset($_GET['category'])){
      if($_GET['category']== "Buscar por"){
      }
      else {
        $idcategoria = \sistema\controladorBD::devolverCategoria($_GET['category']);
        $filter .= "AND idCategoriaProducto LIKE '%".$idcategoria."%'";
      }
    }
      
  

  $cat = \sistema\controladorBD::allCategory();
  $orden = "";

  if(isset($_GET['sort'])){
    $orden = "ORDER BY ";
    if($_GET['sort']=='priceasc'){
      $orden .= "precio ASC";
      if($_SESSION['sort'] == ""){
        $_SESSION['sort'] = $orden;
      }
      else
      {
        if($_GET['sort'] != "priceasc"){
          $_SESSION['sort'] .= ",precio ASC"; 
        }
      }
    }
    if($_GET['sort']=='pricedesc'){
      $orden .= "precio DESC";
      if($_SESSION['sort'] == ""){
        $_SESSION['sort'] = $orden;
      }
      else
      {$_SESSION['sort'] .= ",precio DESC";} 
    }
    if($_GET['sort']=='vencasc'){
      $orden .= "caducidad ASC";
      if($_SESSION['sort'] == ""){

        $_SESSION['sort'] = $orden;
      }
      else
      {$_SESSION['sort'] .= ",caducidad ASC";} 
    }
    if($_GET['sort']=='vencdesc'){
      $orden .= "caducidad DESC";
      if($_SESSION['sort'] == ""){
        $_SESSION['sort'] = $orden;
      }
      else
      {$_SESSION['sort'] .= ",caducidad DESC";} 
    }
  }
  else{$orden .= "nombre ASC";
  $_SESSION['sort']="";
  $_SESSION['sort']="";

}
  $pro = \sistema\controladorBD::allProduct($_SESSION['sort'], $filter, $start, $limit);
  function curPageName(){
    return substr($_SERVER["SCRIPT_NAME"], strpos($_SERVER["SCRIPT_NAME"], "?")+1);
  }

  //echo $_SERVER['QUERY_STRING'];
  
  $rows = \sistema\controladorBD::allProductall($_SESSION['sort'], $filter);
  $total = ceil((sizeof($rows))/$limit);
  if($id>1)
{

echo "
  <li style='
    display: inline; padding: 8px 16px;
    text-decoration: none;
    border-radius: 5px;'><a href='";echo queryString('page', $id-1);echo"' class='button'>PREVIOUS</a></li>";
}
if($id!=$total)
{
echo "<li style='
    display: inline; padding: 8px 16px;
    text-decoration: none;
    border-radius: 5px;'><a href='";echo queryString('page', $id+1); echo"' class='button'>NEXT</a></li>";
}
function queryString($str,$val)
  {
    $queryString = array();
    $queryString = $_GET;
    $queryString[$str] = $val;
    $queryString = "?".htmlspecialchars(http_build_query($queryString),ENT_QUOTES);
 
    return $queryString;
  }
echo "<div class='row' style='
    margin: 10px 0px;
'><ul style='
    display: inline-block;'
 class='page'>";
for($i=1;$i<=$total;$i++)
{
if($i==$id) { echo "<li style='
    display: inline; padding: 8px 16px;
    text-decoration: none;
    border-radius: 5px;' class='current'><a style='float:none; href='#'>".$i."</a></li>"; }

else { echo "<li style='
    display: inline; padding: 8px 16px;
    text-decoration: none;
    border-radius: 5px;'
><a style='float: none;' href='";echo queryString('page', $i);echo"'>".$i."</a></li>"; }
}
echo "</ul></div>"; 

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
          <a class="navbar-brand" href="index.php">Mercadito</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            
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
              <li class><a href='login.php?logout'>Logout</a></li>
            </ul>";
          }
          ?>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
   

<div class="container" id="main">

	<div class="row filter">
		<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Ordenar por <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
  <?php
  if(($_SERVER['QUERY_STRING'] != "&sort=priceasc")){
    if(($_SERVER['QUERY_STRING'] != "&sort=pricedesc")){
  echo"
    <li><a href='index.php?";echo $_SERVER['QUERY_STRING'];echo"&sort=priceasc'>Menor Precio</a></li>
    <li><a href='index.php?";echo $_SERVER['QUERY_STRING'];echo"&sort=pricedesc'>Mayor Precio</a></li> 
    <li role='separator' class='divider'></li>";}}?>
    <?php
    if(($_SERVER['QUERY_STRING'] != "&sort=vencasc")){
      if(($_SERVER['QUERY_STRING'] != "&sort=vencdesc")){
      echo"
    <li><a href='index.php?";echo $_SERVER['QUERY_STRING'];echo "&sort=vencasc'>Vencimiento ASC</a></li>
    <li><a href='index.php?";echo $_SERVER['QUERY_STRING'];echo "&sort=vencdesc'>Vencimiento DESC</a></li>"
    ;}}?>
  </ul>
</div>

	<div class="order">
		
		<form class="navbar-form" method="get" action="<?php echo ($_SERVER['PHP_SELF']);?>">
		<div class="btn-group">
      <select class="selectpicker" name="category">
        <option>Buscar por</option>
        <?php foreach($cat as $key){ ?>
        <?php echo "<option> ". $key->getNombre() ."</option>"; ?>
        <?php } ?>
      </select>
    </div>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="query">
        </div>
        <input type="submit" class="btn btn-default" >
      </form>
	</div>
	</div>
  	<div class="row">
<?php foreach ($pro as $key) {
  $path = "mostrarImagen.php?id=";
  $pathc = \sistema\controladorBD::getCategory($key->getIdCategoria());
?>
  		<div class="product">
  			<img src="<?php echo $path . $key->getId();?>" class="img-responsive" alt="Responsive image" style="
    height: 374px;">
  			<div class="padding">
  				<span class="label label-success"><?php echo $pathc ?></span>
  				<span class="label label-warning"><?php echo $key->getCaducidad();?></span>
		        <h2 class="text-center text-info"><a href="viewProduct.php?id=<?php echo $key->getId();?>"><?php echo $key->getNombre();?></a></h2>
		          <h4 class="text-center"><?php echo $key->getDescripcion();?><span class="label label-primary">$<?php echo $key->getPrecio();?></span></h4>        
        	</div>
          </div>
          <?php } ?>
  		
	</div>
</div>
<?php include("footer.php"); ?>
</body>
</html>