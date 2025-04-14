<?php

require "../config/Conexion.php";

Class Role
{
	public function __contruct()
	{

	}

	public function insertar($nombre,$permisos)
	{
		$sql="INSERT INTO role (nombre)
		VALUES ('$nombre')";
		$idrolenew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO role_permiso(idrole, idpermiso) VALUES('$idrolenew', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;

	}

	public function editar($idrole,$nombre,$permisos)
	{
		$sql="UPDATE role SET nombre='$nombre' WHERE idrole='$idrole'";
        
        ejecutarConsulta($sql);

		//Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel="DELETE FROM role_permiso WHERE idrole='$idrole'";
		ejecutarConsulta($sqldel);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "INSERT INTO role_permiso(idrole, idpermiso) VALUES('$idrole', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
		
	}

	//Implementamos un método para eliminar registros
	public function eliminar($idrole)
	{
		//Eliminamos el rol
		$sql="DELETE FROM role WHERE idrole='$idrole'";
		ejecutarConsulta($sql);
		//Eliminamos todos los permisos asignados al role
		$sqldel="DELETE FROM role_permiso WHERE idrole='$idrole'";
		ejecutarConsulta($sqldel);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idrole)
	{
		$sql="SELECT * FROM role WHERE idrole='$idrole'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listar()
	{
		$sql="SELECT * FROM role";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los permisos marcados
	public function listarmarcados($idrole)
	{
		$sql="SELECT idpermiso FROM role_permiso WHERE idrole='$idrole'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los roles y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM role";
		return ejecutarConsulta($sql);		
	}
}

?>