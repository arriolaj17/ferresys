<?php  

require "../config/Conexion.php";

Class Unidad_Medida
{
	public function __contruct()
	{

	}

	public function insertar($nombre,$prefijo)
	{
		$sql="INSERT INTO unidad_medida (nombre,prefijo,estado)
		VALUES ('$nombre','$prefijo','1')";
		return ejecutarConsulta($sql);
	}

	public function editar($idunidad_medida,$nombre,$prefijo)
	{
		$sql="UPDATE unidad_medida SET nombre='$nombre',prefijo='$prefijo'
		WHERE idunidad_medida='$idunidad_medida'";
		return ejecutarConsulta($sql);
	}

	public function activar($idunidad_medida)
	{
		$sql="UPDATE unidad_medida SET estado='1' WHERE idunidad_medida='$idunidad_medida'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idunidad_medida)
	{
		$sql="UPDATE unidad_medida SET estado='0' WHERE idunidad_medida='$idunidad_medida'";
		return ejecutarConsulta($sql);
	}

	public function mostrar($idunidad_medida)
	{
		$sql="SELECT * FROM unidad_medida WHERE idunidad_medida='$idunidad_medida'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listar()
	{
		$sql="SELECT * FROM unidad_medida";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM unidad_medida where estado=1";
		return ejecutarConsulta($sql);		
	}


}


?>