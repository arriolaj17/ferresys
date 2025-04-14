<?php
require_once "../modelos/Pedido.php";
session_start();
$pedido=new Pedido();

$idpedido=isset($_POST["idpedido"])? limpiarCadena($_POST["idpedido"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idusuario=$_SESSION["idusuario"];
$idsucursal=$_SESSION["idsucursal"];
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$monto_total=isset($_POST["monto_total"])? limpiarCadena($_POST["monto_total"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idpedido)){
			$rspta=$pedido->insertar($idproveedor,$idusuario,$idsucursal,$fecha,$monto_total,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"]);
			echo $rspta ? "Pedido registrado" : "No se pudieron registrar todos los datos del pedido";
		}
		else {
			$rspta=$pedido->editar($idpedido,$idproveedor,$idusuario,$idsucursal,$fecha,$monto_total,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_compra"]);
			echo $rspta ? "Pedido registrado" : "No se pudieron registrar todos los datos del pedido";
		}
	break;

	case 'anular':
		$rspta=$pedido->anular($idpedido);
 		echo $rspta ? "Pedido anulado" : "Pedido no se puede anular";
	break;

	case 'mostrar':
		$rspta=$pedido->mostrar($idpedido);
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
                                    <th><h4 id="total">Gs.'.$total.'</h4><input type="hidden" name="monto_total" id="monto_total"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$pedido->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$url='../reportes/exPedido.php?id=';
 			$data[]=array( 
 				"0"=>($reg->estado)?'<button class="btn btn-primary" onclick="mostrar('.$reg->idpedido.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="comprar('.$reg->idpedido.',\''.$reg->idproveedor.'\',\''.$reg->monto_total.'\')"><i class="fa fa-shopping-cart"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idpedido.')"><i class="fa fa-pencil"></i></button>'.'<a target="_blank" href="'.$url.$reg->idpedido.'"> <button class="btn btn-info"><i class="fa fa-file"></i></button></a>',
 				"1"=>$reg->idpedido,
 				"2"=>$reg->fecha,
 				"3"=>$reg->proveedor,
 				"4"=>$reg->usuario,
 				"5"=>($reg->estado)?'<span class="label bg-green">Pendiente</span>':
 				'<span class="label bg-red">Terminado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectProveedor':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarP();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
				}
	break;

	case 'listarArticulos':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivos();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->categoria,
 				"3"=>$reg->codigo,
 				"4"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
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