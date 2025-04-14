<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Articulo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idsucursal,$idcategoria,$idunidad_medida,$nombre,$stock,$descripcion,$codigo,$imagen)
	{
		$sql="INSERT INTO articulo (idsucursal,idcategoria,idunidad_medida,nombre,stock,descripcion,codigo,imagen)
		VALUES ('$idsucursal','$idcategoria','$idunidad_medida','$nombre','$stock','$descripcion','$codigo','$imagen')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idarticulo,$idsucursal,$idcategoria,$idunidad_medida,$nombre,$descripcion,$codigo,$imagen)
	{
		$sql="UPDATE articulo SET idsucursal='idsucursal',idcategoria='$idcategoria',idunidad_medida='$idunidad_medida',nombre='$nombre',descripcion='$descripcion',codigo='$codigo',imagen='$imagen' WHERE idarticulo='$idarticulo' AND idsucursal='$idsucursal'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros 
	public function eliminar($idarticulo)
	{
		$sql="DELETE FROM articulo WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idarticulo)
	{
		$sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar($idsucursal)
	{
		$sql="SELECT a.idarticulo,a.idsucursal,s.razon_social as sucursal,a.idcategoria,c.nombre as categoria,u.nombre as unidad_medida,a.codigo,a.nombre,a.stock,a.descripcion,a.imagen FROM articulo a JOIN categoria c ON a.idcategoria=c.idcategoria JOIN unidad_medida u ON a.idunidad_medida=u.idunidad_medida JOIN sucursal s  ON a.idsucursal=s.idsucursal WHERE a.idsucursal='$idsucursal'";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.imagen FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
	public function listarActivosVenta()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria ,a.codigo,a.nombre,a.stock,(SELECT precio_compra FROM detalle_compra WHERE idarticulo=a.idarticulo order by iddetalle_compra desc limit 0,1)+(c.porc_ganancia *(SELECT precio_compra FROM detalle_compra WHERE idarticulo=a.idarticulo order by iddetalle_compra desc limit 0,1)) as precio_venta,a.descripcion,a.imagen FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria";
		return ejecutarConsulta($sql);		
	}
}
?>