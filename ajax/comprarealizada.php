<?php
require_once "../modelos/Compra.php";


$compra=new Compra();


switch ($_GET["op"]){
	case 'mostrar':
		$rspta=$compra->mostrar($idcompra);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

    case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $pedido->listarDetalle($id);
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
                                    <th><h4 id="total">Gs/.'.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$compra->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha,	
 				"1"=>$reg->idcompra,
 				"2"=>$reg->idpedido,
 				"3"=>$reg->proveedor,
 				"4"=>$reg->usuario,
 				"5"=>$reg->tipo_comprobante,
 				"6"=>$reg->serie_comprobante.'-'.$reg->nro_comprobante,
 				"7"=>$reg->total_compra,
 				"8"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
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