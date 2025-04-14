<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Compra
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idpedido,$idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$nro_comprobante,$fecha,$impuesto,$total_compra,$rsp)
	{
		$sql="INSERT INTO compra (idpedido,idproveedor,idusuario,tipo_comprobante,serie_comprobante,nro_comprobante,fecha,impuesto,total_compra,estado)
		VALUES ('$idpedido','$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$nro_comprobante','$fecha','$impuesto','$total_compra','Aceptado')";
		$idcompranew=ejecutarConsulta_retornarID($sql);
        
       $sw=true;
        while($reg=$rsp->fetch_object())
        {
          $sql_detalle = "INSERT INTO detalle_compra(idcompra,idarticulo,cantidad,precio_compra) VALUES
            ('$idcompranew',".$reg->idarticulo.",".$reg->cantidad.",".$reg->precio_compra.")";
          ejecutarConsulta($sql_detalle) or $sw = false;
        }

        return $sw;
			
				
	}

	
	//Implementamos un método para anular categorías
	public function anular($idcompra)
	{
		$sql="UPDATE compra SET estado='Anulado' WHERE idcompra='$idcompra'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcompra)
	{
		$sql="SELECT c.idcompra,p.nombre as proveedor,u.idusuario,u.nombre as usuario,c.tipo_comprobante,c.serie_comprobante, c.nro_comprobante, c.fecha, c.impuesto, c.total_compra,i.idpedido,DATE(i.fecha) as fecha FROM compra c JOIN pedido i on c.idpedido=i.idpedido INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE c.idcompra='$idcompra'";
		return ejecutarConsultaSimpleFila($sql);
	}


	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT i.idcompra,i.idpedido,p.nombre as proveedor,i.fecha,u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.nro_comprobante,i.total_compra,i.estado FROM compra i  JOIN persona p ON i.idproveedor=p.idpersona JOIN pedido pe ON pe.idpedido=i.idpedido JOIN usuario u ON i.idusuario=u.idusuario";
		return ejecutarConsulta($sql);		
	}
	
	public function listarDetalle($idpedido)
	{
		$sql="SELECT di.idpedido,di.idarticulo,a.nombre,di.cantidad,di.precio_compra FROM detalle_pedido di inner join articulo a on di.idarticulo=a.idarticulo where di.idpedido='$idpedido'";
		return ejecutarConsulta($sql);
	}


}

?>