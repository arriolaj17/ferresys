<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['reportes']==1)
{
require "../config/Conexion.php";
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style type="text/css">
#container {
	height: 400px; 
	min-width: 310px; 
	max-width: 800px;
	margin: 0 auto;
}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column',
            margin: 95,
            options3d: {
                enabled: true,
                alpha: 0,
                beta: 0,
                depth: 50,
                viewDistance: 25
            }
        },
        title: {
            text: 'Ventas Totales por Vendedor Corte de Control'
        },
        subtitle: {
            text: 'Notice the difference between a 0 value and a null point'
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            categories: [
			<?php
			require_once "../modelos/Consultas.php";
			$consulta = new Consultas();

			$rspta = $consulta->ventasultimosdias();
			while($reg= $rspta->fetch_object()){
						
			 $nombre = $reg->nombre;
             $total = $reg->total;
             ?>
					
			
			['<?php echo $nombre; ?>'],
<?php
}
?>
			]
        },
        yAxis: {
            title: {
                text: null
            }
        },
        series: [{
            name: 'Ventas Totales',
            data: [
			
			<?php
			require_once "../modelos/Consultas.php";
			$consulta = new Consultas();

			$rspta = $consulta->ventasultimosdias();
			while($reg= $rspta->fetch_object()){
						
			 $nombre = $reg->nombre;
             $total = $reg->total;
             ?>
			
			[<?php echo $total ?>],
			
<?php
}
?>
			]
        }]
    });
});
		</script>
	</head>
	<body>

<script src="../reportes_graficos/Highcharts-4.1.5/js/highcharts.js"></script>
<script src="../reportes_graficos/Highcharts-4.1.5/js/highcharts-3d.js"></script>
<script src="../reportes_graficos/Highcharts-4.1.5/js/modules/exporting.js"></script>

<div id="container" style="height: 400px"></div>
	</body>
</html>

?>
<?php
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>