<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Pedido
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idproveedor,$idusuario,$idsucursal,$fecha,$monto_total,$idarticulo,$cantidad,$precio_compra)
	{
		$sql="INSERT INTO pedido (idproveedor,idusuario,idsucursal,monto_total,fecha,estado)
		VALUES ('$idproveedor','$idusuario','$idsucursal','$monto_total','$fecha','1')";
		//return ejecutarConsulta($sql);
		$idpedidonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle = "INSERT INTO detalle_pedido(idpedido, idarticulo,cantidad,precio_compra) VALUES ('$idpedidonew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	//Implementamos un método para insertar registros
	public function editar($idproveedor,$idusuario,$idsucursal,$fecha,$monto_total,$idarticulo,$cantidad,$precio_compra)
	{
		$sql="INSERT INTO pedido (idproveedor,idusuario,idsucursal,monto_total,fecha,estado)
		VALUES ('$idproveedor','$idusuario','$idsucursal','$monto_total','$fecha','1')";
		//return ejecutarConsulta($sql);
		$idpedidonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
			$sql_detalle = "INSERT INTO detalle_pedido(idpedido, idarticulo,cantidad,precio_compra) VALUES ('$idpedidonew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	
	//Implementamos un método para anular categorías
	public function anular($idpedido)
	{
		$sql="UPDATE pedido SET estado='0' WHERE idpedido='$idpedido'";
		return ejecutarConsulta($sql);
	}
    
    



	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idpedido)
	{
		$sql="SELECT i.idpedido,DATE(i.fecha) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.monto_total,i.estado FROM pedido i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idpedido='$idpedido'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idpedido)
	{
		$sql="SELECT di.idpedido,di.idarticulo,a.nombre,di.cantidad,di.precio_compra FROM detalle_pedido di inner join articulo a on di.idarticulo=a.idarticulo where di.idpedido='$idpedido'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT i.idpedido,DATE(i.fecha) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.monto_total,i.estado FROM pedido i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario ORDER BY i.idpedido desc";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function selectidproveedor($idpedido)
	{
		$sql="SELECT i.idproveedor FROM pedido i JOIN persona p ON i.idproveedor=p.idpersona JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idpedido='$idpedido'";
		return ejecutarConsulta($sql);		
	}

    public function listarped($idpedido)
	{
		$sql="SELECT di.idpedido,di.idarticulo,a.nombre,di.cantidad,di.precio_compra,(di.cantidad*di.precio_compra) as subtotal FROM detalle_pedido di inner join articulo a on di.idarticulo=a.idarticulo where di.idpedido='$idpedido'";
		return ejecutarConsulta($sql);
	}

	public function listarcab($idpedido)
	{
		$sql="SELECT i.idpedido,DATE(i.fecha) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.monto_total,i.estado FROM pedido i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idpedido='$idpedido'";
		return ejecutarConsulta($sql);
	}
	
}

?>