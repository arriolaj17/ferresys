<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class General
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

    public function insertar($empresa,$impuesto,$porcentaje,$simbolo_moneda,$imagen)
	{
		$sql="INSERT INTO global (empresa,impuesto,porcentaje,simbolo_moneda,imagen)
		VALUES ('$empresa','$impuesto','$porcentaje','$simbolo_moneda','$imagen')";
		return ejecutarConsulta($sql);
	}
	//Implementamos un método para editar registros
	public function editar($idglobal,$empresa,$impuesto,$porcentaje,$simbolo_moneda,$imagen)
	{
		$sql="UPDATE global SET empresa='$empresa',impuesto='$impuesto',porcentaje='$porcentaje',simbolo_moneda='$simbolo_moneda',imagen='$imagen' WHERE idglobal='$idglobal'";
		return ejecutarConsulta($sql);
	}

	
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idglobal)
	{
		$sql="SELECT * FROM global WHERE idglobal='$idglobal'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM global";
		return ejecutarConsulta($sql);		
	}

	public function activar($idglobal)
	{
		$sql="UPDATE global SET estado='1' WHERE idglobal='$idglobal'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idcategoria)
	{
		$sql="UPDATE global SET estado='0' WHERE idglobal='$idglobal'";
		return ejecutarConsulta($sql);
	}
}
?>