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
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'PERSONAS QUE DEBEN, 2015'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Deudores',
            data: [
			
			<?php
			require_once "../modelos/Consultas.php";
			$consulta = new Consultas();

			$rspta = $consulta->comprasultimosdias();
			while($reg= $rspta->fetch_object()){
						
			 $nombre = $reg->nombre;
             $total = $reg->total;
             ?>
             ['<?php echo $nombre ?>', <?php echo $total ?> ],
             
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
<script src="../reportes_graficos/Highcharts-4.1.5/js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
<br><br>
<center>
<?php
echo 'Nombre de usuario| Monto Total';

			require_once "../modelos/Consultas.php";
			$consulta = new Consultas();

			$rspta = $consulta->comprasultimosdias();
while($reg= $rspta->fetch_object()){
	$nombre = $reg->nombre;
    $total = $reg->total;

   echo $nombre,$total."\n";
}
?>
</center>
	</body>
</html>




<?php
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>