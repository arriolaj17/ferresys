<?php
require_once "../modelos/Compra.php";
session_start();

$compra=new Compra();

$idcompra=isset($_POST["idcompra"])? limpiarCadena($_POST["idcompra"]):"";
$idpedido=isset($_POST["idpedido"])? limpiarCadena($_POST["idpedido"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idusuario=$_SESSION["idusuario"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$nro_comprobante=isset($_POST["nro_comprobante"])? limpiarCadena($_POST["nro_comprobante"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
	require_once "../modelos/Pedido.php";
        $pedido=new Pedido();
		if (empty($idcompra)){
			$rsp=$pedido->listarDetalle($idpedido);
			$rspta=$compra->insertar($idpedido,$idproveedor,$idusuario,$tipo_comprobante,$serie_comprobante,$nro_comprobante,$fecha,$impuesto,$total_compra,$rsp);
			$rspt=$pedido->anular($idpedido);
            echo $rspta ? "Compra registrada" : "No se pudieron registrar todos los datos de la compra";
		}
		else {
		}
	break;

    case 'listardetalle':
    require_once "../modelos/Pedido.php";
        $pedido=new Pedido();


		$rspta = $pedido->listarDetalle($idpedido);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_compra.'</td><td>'.$reg->precio_compra*$reg->cantidad.'</td></tr>';
					$total=$total+($reg->precio_compra*$reg->cantidad);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th> 
                                </tfoot>';
    break;


	case 'anular':
		$rspta=$compra->anular($idcompra);
 		echo $rspta ? "Compra anulada" : "Compra no se puede anular";
	break;

	case 'mostrar':
		$rspta=$compra->mostrar($idcompra);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'listar':
		$rspta=$compra->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->idcompra,
 				"1"=>$reg->idpedido,
 				"2"=>$reg->proveedor,
 				"3"=>$reg->usuario,
 				"4"=>$reg->tipo_comprobante,
 				"5"=>$reg->serie_comprobante.'-'.$reg->nro_comprobante,
 				"6"=>$reg->total_compra,
 				"7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Anulado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
    
}
?>