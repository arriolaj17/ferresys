<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idsucursal,$nombre,$tipo_documento,$nro_documento,$cargo,$direccion,$telefono,$email,$imagen,$login,$clave,$idrole)
	{
		$sql="INSERT INTO usuario (idsucursal,nombre,tipo_documento,nro_documento,cargo,direccion,telefono,email,imagen,login,clave,estado)
		VALUES ('$idsucursal','$nombre','$tipo_documento','$nro_documento','$cargo','$direccion','$telefono','$email','$imagen','$login','$clave','1')";
		//return ejecutarConsulta($sql);
		$idusuarionew=ejecutarConsulta_retornarID($sql);
		
			$sql_detalle = "INSERT INTO usuario_role(idusuario, idrole) VALUES('$idusuarionew', '$idrole')";
			ejecutarConsulta($sql_detalle);

		
	}
		
	//Implementamos un método para editar registros
	public function editar($idusuario,$idsucursal,$nombre,$tipo_documento,$nro_documento,$cargo,$direccion,$telefono,$email,$imagen,$login,$clave,$idrole)
	{
		$sql="UPDATE usuario SET idsucursal='$idsucursal',nombre='$nombre',tipo_documento='$tipo_documento',nro_documento='$nro_documento',cargo='$cargo',direccion='$direccion',telefono='$telefono',email='$email',imagen='$imagen',login='$login',clave='$clave' WHERE idusuario='$idusuario'";
		ejecutarConsulta($sql);

		//Eliminamos el role y asignamos el nuevo
		$sqldel="DELETE FROM usuario_role WHERE idusuario='$idusuario'";
		ejecutarConsulta($sqldel);

		$sql_detalle = "INSERT INTO usuario_role(idusuario, idrole) VALUES('$idusuario', '$idrole')";
		ejecutarConsulta($sql_detalle);

	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idusuario)
	{
		$sql="UPDATE usuario SET estado='0' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idusuario)
	{
		$sql="UPDATE usuario SET estado='1' WHERE idusuario='$idusuario'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)
	{
		$sql="SELECT * FROM usuario WHERE idusuario='$idusuario'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT u.idusuario,u.idsucursal,s.razon_social as sucursal,u.nombre,u.tipo_documento,u.nro_documento,u.telefono,u.email,u.login,u.imagen,u.estado FROM usuario u JOIN sucursal s ON u.idsucursal=s.idsucursal";
		return ejecutarConsulta($sql);			
	}

	//Función para verificar el acceso al sistema
	public function verificar($login,$clave)
    {
    	$sql="SELECT u.idusuario,u.idsucursal,u.nombre,s.razon_social,u.imagen,u.login,r.idrole FROM usuario u JOIN sucursal s ON u.idsucursal=s.idsucursal JOIN usuario_role r ON u.idusuario=r.idusuario WHERE u.login='$login' AND u.clave='$clave' AND u.estado='1'"; 
    	return ejecutarConsulta($sql);  
    }

    //Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM usuario WHERE estado=1";
		return ejecutarConsulta($sql);		
	}
}

?>