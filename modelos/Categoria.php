<?php 

require "../config/Conexion.php";

Class Categoria
{
	public function __contruct()
	{

	}

	public function insertar($nombre,$descripcion,$porc_ganancia)
	{
		$sql="INSERT INTO categoria (nombre,descripcion,porc_ganancia,estado)
		VALUES ('$nombre','$descripcion',$porc_ganancia,'1')";
		return ejecutarConsulta($sql);
	}

	public function editar($idcategoria,$nombre,$descripcion,$porc_ganancia)
	{
		$sql="UPDATE categoria SET nombre='$nombre',descripcion='$descripcion',porc_ganancia='$porc_ganancia'
		WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	public function activar($idcategoria)
	{
		$sql="UPDATE categoria SET estado='1' WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idcategoria)
	{
		$sql="UPDATE categoria SET estado='0' WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}
	
	public function mostrar($idcategoria)
	{
		$sql="SELECT * FROM categoria WHERE idcategoria='$idcategoria'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listar()
	{
		$sql="SELECT * FROM categoria";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM categoria WHERE estado=1";
		return ejecutarConsulta($sql);		
	}
}

?>