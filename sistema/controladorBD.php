<?php
namespace sistema;
require_once ('constantes.php');
require_once ('clases/usuario.php');
require_once ('clases/categoria.php');
require_once ('clases/producto.php');
use Exception;
class controladorBD{

	public static function usuarioLogueado(){
			try{
				if (!isset($_SESSION['id'])) { //Si no hay un usuario logueado
					$usuario=null;
					$error = 'Para acceder a esta seccion debe loguearse';
					throw new Exception($error);
				}
				else{
					return true;
				}
			
			}catch (Exception $e)
			{	
				throw $e;
			}
		}
	//Usuarios----------------------------------------->
	public static function comprobarUsuario($username){
		$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME); 
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if(!($query = $mysqli->prepare("SELECT * FROM usuarios WHERE email=?"))){
			 die('ERROR AL CARGAR LA INFORMACION DE USUARIO3 (' . $mysqli->errno . '): ' . $mysqli->error);
		}
		if (!$query->bind_param("s", $username)) {
        }
		if (!$query->execute()) {
        }
		if(!$query->fetch()){ //NO encontro el usuario
			$u = null;
		}else {
           $u=$username;
        }
		$query->close();
        $mysqli->close();
		return $u;
	}

	public static function crearUsuario(\clases\usuario $usuario){
		$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME); 
        
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if(!($query = $mysqli->prepare("INSERT INTO usuarios(nombre, apellido, clave, email, telefono)". "VALUES(?,?,?,?,?)"))){
			return false;				
		}
		if(!$query->bind_param("sssss",$usuario->getNombre(),$usuario->getApellido(), $usuario->getClave(), $usuario->getEmail(),
			$usuario->getTelefono())){
			return false;
		}
		if (!$query->execute()) { 
			return false;
        }
        return true;
	}

	public static function updateUsuario(\clases\usuario $usuario){
		$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
        if(!($query = $mysqli->prepare("UPDATE usuarios SET nombre = ?, apellido = ?,telefono = ?,email = ?, clave = ? WHERE idUsuario = ?"))){
			return false;			
		}
		if (!$query->bind_param("ssssss", $usuario->getNombre(), $usuario->getApellido(), $usuario->getTelefono(), $usuario->getEmail(), $usuario->getClave(),   $usuario->getId())) {
            return false;
        }
		if (!$query->execute()) { 
			return false;
        }
        return true;
	}

	public static function loginUsuario($email, $password)	{
		$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if(!$query = $mysqli->prepare("SELECT idUsuario, nombre, apellido, telefono FROM usuarios WHERE email=? AND clave=?")){
			
		}
		if (!$query->bind_param("ss", $email, $password)) {
            return false;
        }
        try {
			
		
		if (!$query->execute()) {
			$error = 'Para acceder a esta seccion debe loguearse';
			throw new Exception($error);
        }
        $query->store_result();
        if (!$query->bind_result($idUsuario, $nombre, $apellido, $telefono)) {
            return false;
        }
        
		if($query->fetch()){
			$u = new \clases\usuario();
			$u->setId($idUsuario);
			$u->setEmail($email);
			$u->setClave($password);
			$u->setApellido($apellido);
			$u->setNombre($nombre);
			$u->setTelefono($telefono);
			return $u;
		}else{
			$error = 'ERROR! La contraseña no es correcta';
			throw new Exception($error);
		}

		}catch (Exception $e) {
				throw $e;
				
			}
		
        
		$query->close();
        $mysqli->close();
		
	}

	public static function datosUsuario($id)	{
		$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if(!$query = $mysqli->prepare("SELECT idUsuario, nombre, apellido, telefono, email FROM usuarios WHERE idUsuario=? ")){
			
		}
		if (!$query->bind_param("s", $id)) {
            return false;
        }
        try {
			
		
		if (!$query->execute()) {
			$error = 'Para acceder a esta seccion debe loguearse';
			throw new Exception($error);
        }
        $query->store_result();
        if (!$query->bind_result($idUsuario, $nombre, $apellido, $telefono, $email)) {
            return false;
        }
        
		if($query->fetch()){
			$u = new \clases\usuario();
			$u->setId($idUsuario);
			$u->setEmail($email);
			$u->setApellido($apellido);
			$u->setNombre($nombre);
			$u->setTelefono($telefono);
			return $u;
		}else{
			$error = 'ERROR! El ID de usuario es inexistente';
			throw new Exception($error);
		}

		}catch (Exception $e) {
				throw $e;
				
			}
		
        
		$query->close();
        $mysqli->close();
		
	}

	public static function logout() {
        session_unset();
        session_destroy();
    }

    //Fin usuarios -------------------------------------------------->


    //Categorias----------------------------------------------------->
    public static function comprobarCategoria($nombre){
		$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME); 
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if(!($query = $mysqli->prepare("SELECT * FROM categorias_productos WHERE nombre=?"))){
			 die('ERROR AL CARGAR LA INFORMACION DE USUARIO3 (' . $mysqli->errno . '): ' . $mysqli->error);
		}
		if (!$query->bind_param("s", $nombre)) {
			die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!$query->execute()) {
			die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if($query->fetch()){ //NO encontro una categoria con el mismo nombre
			$u = null;
		}else {
           $u=$nombre;
        }
		$query->close();
        $mysqli->close();
		return $u;
	}
	public static function crearCategoria($nombre){
		$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME); 
        
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if(!($query = $mysqli->prepare("INSERT INTO categorias_productos(nombre)". "VALUES(?)"))){
			return false;				
		}
		if(!$query->bind_param("s",$nombre)){
			return false;
		}
		if (!$query->execute()) { 
			return false;
        }
        return true;
	}
    public static function allCategory(){
    	$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);         
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!($query = $mysqli->prepare("Select idCategoriaProducto, nombre from categorias_productos"))) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		if (!$query->execute()) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		$query->store_result();
		if (!$query->bind_result($id, $nombre)) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		$tipo = Array();
        while ($query->fetch()) {
            $t = new \clases\categoria();
            $t->setId($id);
			$t->setNombre($nombre);
            $tipo[] = $t;
        }
        $query->close();
        $mysqli->close();
        return $tipo;
    }
    public static function getCategory($id){
    	$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);         
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!($query = $mysqli->prepare("SELECT nombre FROM categorias_productos WHERE idCategoriaProducto=?"))) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        if (!$query->bind_param("s", $id)) {
			die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!$query->execute()) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		$query->store_result();
		if (!$query->bind_result($nombre)) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        while ($query->fetch()) {		
            $tipo = $nombre;}
        $query->close();
        $mysqli->close();
        return $tipo;
    }



    public static function getUserById($id){
    	$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);         
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!($query = $mysqli->prepare("SELECT nombre, apellido, email, telefono FROM usuarios WHERE idUsuario=?"))) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        if (!$query->bind_param("s", $id)) {
			die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!$query->execute()) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		$query->store_result();
		if (!$query->bind_result($nombre, $apellido, $email, $telefono)) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        if ($query->fetch()) {		
            $tipo = new \clases\usuario();
            $tipo->setId($id);
            $tipo->setNombre($nombre);
            $tipo->setApellido($apellido);
            $tipo->setEmail($email);
            $tipo->setTelefono($telefono);
        }
        $query->close();
        $mysqli->close();
        return $tipo;
    }

    public static function devolverCategoria($nombre){
		$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME); 
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if(!($query = $mysqli->prepare("SELECT idCategoriaProducto FROM categorias_productos WHERE nombre=?"))){
			 die('ERROR AL CARGAR LA INFORMACION DE USUARIO3 (' . $mysqli->errno . '): ' . $mysqli->error);
		}
		if (!$query->bind_param("s", $nombre)) {
			die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!$query->execute()) {
			die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
        $query->store_result();
		if (!$query->bind_result($idCategoriaProducto)) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		if($query->fetch()){ //NO encontro una categoria con el mismo nombre
			$u = $idCategoriaProducto;
		}
		$query->close();
        $mysqli->close();
		return $u;
	}
    //Categorias----------------------------------------------------->


    //Productos------------------------------------------------------>
    public static function crearProducto(\clases\producto $producto){
		$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME); 
        
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if(!($query = $mysqli->prepare("INSERT INTO productos(idCategoriaProducto, idUsuario, nombre, descripcion, precio, publicacion, caducidad, contenidoimagen, tipoimagen)". "VALUES(?,?,?,?,?,?,?,?,?)"))){
			die('ERROR AL CARGAR LA INFORMACION DE USUARIO3 (' . $mysqli->errno . '): ' . $mysqli->error);				
		}
		if(!$query->bind_param("sssssssss",$producto->getIdCategoria(),$producto->getIdUsuario(), $producto->getNombre(), $producto->getDescripcion(),$producto->getPrecio(), $producto->getPublicacion(), $producto->getCaducidad(), $producto->getContenidoImagen(), $producto->getTipoImagen())){
			die('ERROR AL CARGAR LA INFORMACION DE USUARIO3 (' . $mysqli->errno . '): ' . $mysqli->error);
		}
		if (!$query->execute()) { 
			die('ERROR AL CARGAR LA INFORMACION DE USUARIO3 (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        return true;
	}
	public static function updateProducto(\clases\producto $producto){
		$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME); 
        
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if(!($query = $mysqli->prepare("UPDATE productos SET idCategoriaProducto =?, idUsuario= ?, nombre=?, descripcion=?, precio=?
			WHERE idProducto=?"))){
			die('ERROR AL CARGAR LA INFORMACION DE USUARIO3 (' . $mysqli->errno . '): ' . $mysqli->error);				
		}
		if(!$query->bind_param("ssssss",$producto->getIdCategoria(),$producto->getIdUsuario(), $producto->getNombre(), $producto->getDescripcion(),$producto->getPrecio(), $producto->getId())){
			die('ERROR AL CARGAR LA INFORMACION DE USUARIO3 (' . $mysqli->errno . '): ' . $mysqli->error);
		}
		if (!$query->execute()) { 
			die('ERROR AL CARGAR LA INFORMACION DE USUARIO3 (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        return true;
	}


	public static function allProduct($orden, $query, $start, $limit){
		$time = date_default_timezone_get();
		$date = date(("Y/m/d"), time());
    	$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);         
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!($query = $mysqli->prepare("SELECT idProducto,idCategoriaProducto, idUsuario, nombre, descripcion, precio, publicacion, caducidad, contenidoimagen, tipoimagen FROM productos 
			where caducidad >=? $query $orden LIMIT $start, $limit"))) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        if (!$query->bind_param("s", $date )) {
			die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!$query->execute()) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		$query->store_result();
		if (!$query->bind_result($id, $idcategoria,$idusuario, $nombre, $descripcion, $precio, $publicacion, $caducidad, $contenidoimagen, $tipoimagen)) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		$tipo = Array();
        while ($query->fetch()) {
            $t = new \clases\producto();
            $t->setId($id);
            $t->setIdCategoria($idcategoria);
            $t->setIdUsuario($idusuario);
			$t->setNombre($nombre);
			$t->setDescripcion($descripcion);
			$t->setPrecio($precio);
			$t->setPublicacion($publicacion);
			$t->setCaducidad($caducidad);
			$t->setContenidoImagen($contenidoimagen);
			$t->setTipoImagen($tipoimagen);
            $tipo[] = $t;
        }
        $query->close();
        $mysqli->close();
        return $tipo;
    }
    public static function allProductall($orden, $query){
		$time = date_default_timezone_get();
		$date = date(("Y/m/d"), time());


    	$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);         
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!($query = $mysqli->prepare("SELECT idProducto,idCategoriaProducto, idUsuario, nombre, descripcion, precio, publicacion, caducidad, contenidoimagen, tipoimagen FROM productos 
			where caducidad >=? $query $orden"))) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        if (!$query->bind_param("s", $date )) {
			die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!$query->execute()) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		$query->store_result();
		if (!$query->bind_result($id, $idcategoria,$idusuario, $nombre, $descripcion, $precio, $publicacion, $caducidad, $contenidoimagen, $tipoimagen)) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		$tipo = Array();
        while ($query->fetch()) {
            $t = new \clases\producto();
            $t->setId($id);
            $t->setIdCategoria($idcategoria);
            $t->setIdUsuario($idusuario);
			$t->setNombre($nombre);
			$t->setDescripcion($descripcion);
			$t->setPrecio($precio);
			$t->setPublicacion($publicacion);
			$t->setCaducidad($caducidad);
			$t->setContenidoImagen($contenidoimagen);
			$t->setTipoImagen($tipoimagen);
            $tipo[] = $t;
        }
        $query->close();
        $mysqli->close();
        return $tipo;
    }

    public static function getProductoById($id){
		$time = date_default_timezone_get();
		$date = date(("Y/m/d"), time());
    	$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);         
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!($query = $mysqli->prepare("SELECT idProducto,idCategoriaProducto, idUsuario, nombre, descripcion, precio, publicacion, caducidad, contenidoimagen, tipoimagen FROM productos 
			where caducidad >=? AND idProducto =?"))) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        if (!$query->bind_param("ss", $date, $id )) {
			die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!$query->execute()) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		$query->store_result();
		if (!$query->bind_result($id, $idcategoria,$idusuario, $nombre, $descripcion, $precio, $publicacion, $caducidad, $contenidoimagen, $tipoimagen)) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		
        if ($query->fetch()) {
            $t = new \clases\producto();
            $t->setId($id);
            $t->setIdCategoria($idcategoria);
            $t->setIdUsuario($idusuario);
			$t->setNombre($nombre);
			$t->setDescripcion($descripcion);
			$t->setPrecio($precio);
			$t->setPublicacion($publicacion);
			$t->setCaducidad($caducidad);
			$t->setContenidoImagen($contenidoimagen);
			$t->setTipoImagen($tipoimagen);
        }
        $query->close();
        $mysqli->close();
        return $t;
    }
    public static function getProductoByUserId($id){
		$time = date_default_timezone_get();
		$date = date(("Y/m/d"), time());
    	$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);         
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!($query = $mysqli->prepare("SELECT idProducto,idCategoriaProducto, idUsuario, nombre, descripcion, precio, publicacion, caducidad, contenidoimagen, tipoimagen FROM productos 
			where idUsuario = ? ORDER BY caducidad ASC"))) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        if (!$query->bind_param("s", $id )) {
			die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if (!$query->execute()) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		$query->store_result();
		if (!$query->bind_result($id, $idcategoria,$idusuario, $nombre, $descripcion, $precio, $publicacion, $caducidad, $contenidoimagen, $tipoimagen)) {
            die('ERROR AL PREPARAR LAS ULTIMAS NOVEDADES (' . $mysqli->errno . '): ' . $mysqli->error);
        }
		$tipo = Array();
        while ($query->fetch()) {
            $t = new \clases\producto();
            $t->setId($id);
            $t->setIdCategoria($idcategoria);
            $t->setIdUsuario($idusuario);
			$t->setNombre($nombre);
			$t->setDescripcion($descripcion);
			$t->setPrecio($precio);
			$t->setPublicacion($publicacion);
			$t->setCaducidad($caducidad);
			$t->setContenidoImagen($contenidoimagen);
			$t->setTipoImagen($tipoimagen);
			$tipo[] = $t;
        }
        $query->close();
        $mysqli->close();
        return $tipo;
    }
    public static function deleteProducto($id) {
        $mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);         
        if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
        if (!($query = $mysqli->prepare("DELETE FROM productos WHERE idProducto=?"))) {
            die('ERROR AL ELIMINAR LA INFORMACION (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        if (!$query->bind_param("i", $id)) {
            die('ERROR AL ELIMINAR LA INFORMACION (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        if (!$query->execute()) {
            die('ERROR AL ELIMINAR LA INFORMACION (' . $mysqli->errno . '): ' . $mysqli->error);
        }
    }

    public static function deleteCategoria($id) {
        $mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);         
        if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
        if (!($query = $mysqli->prepare("DELETE FROM categorias_productos WHERE idCategoriaProducto=?"))) {
            return false;
        }
        if (!$query->bind_param("i", $id)) {
            return false;
        }
        if (!$query->execute()) {
            return false;
        }
        return true;
    }

    public static function updateCategoria($nombre, $id){
		$mysqli = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME); 
        
		if ($mysqli->connect_errno) {
            die('ERROR AL ACCEDER A LA BASE DE DATOS DEL SISTEMA (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
        }
		if(!($query = $mysqli->prepare("UPDATE categorias_productos SET nombre =?
			WHERE idCategoriaProducto=?"))){
			die('ERROR AL CARGAR LA INFORMACION DE USUARIO3 (' . $mysqli->errno . '): ' . $mysqli->error);				
		}
		if(!$query->bind_param("ss",$nombre, $id)){
			die('ERROR AL CARGAR LA INFORMACION DE USUARIO3 (' . $mysqli->errno . '): ' . $mysqli->error);
		}
		if (!$query->execute()) { 
			die('ERROR AL CARGAR LA INFORMACION DE USUARIO3 (' . $mysqli->errno . '): ' . $mysqli->error);
        }
        return true;
	}





}
?>