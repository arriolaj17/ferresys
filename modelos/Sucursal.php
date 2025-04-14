<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Sucursal
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($razon_social,$tipo_documento,$nro_documento,$direccion,$telefono,$email,$representante,$imagen)
	{
		$sql="INSERT INTO sucursal (razon_social,tipo_documento,nro_documento,direccion,telefono,email,representante,imagen,estado)
		VALUES ('$razon_social','$tipo_documento','$nro_documento','$direccion','$telefono','$email','$representante','$imagen','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idsucursal,$razon_social,$tipo_documento,$nro_documento,$direccion,$telefono,$email,$representante,$imagen)
	{
		$sql="UPDATE sucursal SET idsucursal='$idsucursal',razon_social='$razon_social',tipo_documento='$tipo_documento',nro_documento='$nro_documento',direccion='$direccion',telefono='$telefono',email='$email',representante='$representante',imagen='$imagen' WHERE idsucursal='$idsucursal'";
		return ejecutarConsulta($sql);
	}

	public function activar($idsucursal)
	{
		$sql="UPDATE sucursal SET estado='1' WHERE idsucursal='$idsucursal'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idsucursal)
	{
		$sql="UPDATE sucursal SET estado='0' WHERE idsucursal='$idsucursal'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idsucursal)
	{
		$sql="SELECT * FROM sucursal WHERE idsucursal='$idsucursal'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT idsucursal,razon_social,direccion,telefono,representante,imagen,estado FROM sucursal";
		return ejecutarConsulta($sql);		
	}
    
    //Implementar un método para listar las sucursales y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM sucursal WHERE estado=1";
		return ejecutarConsulta($sql);		
	}
}
?>