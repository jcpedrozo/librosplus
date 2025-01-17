<?php 

error_reporting(0);

$respuesta = ControladorReservas::ctrMostrarReservas(null, null);

$arrayFechas = array();
$sumaPagosMes = array();

foreach ($respuesta as $key => $value){

	// Capturar año y mes
	$fecha = substr($value["fechaReserva"],0,7);

	// Introducir las fechas en arrayFechas
	array_push($arrayFechas, $fecha);
	
	// Capturar las ventas
	$arrayVentas = array($fecha => $value["pagoReserva"]);
	
	// Sumar los pagos que ocurrieron el mismo mes

	foreach ($arrayVentas as $key2 => $value2) {
		$sumaPagosMes[$key2] += $value2;	
	}
}

$noRepetirFechas = array_unique($arrayFechas);


?>


<div class="card bg-gradient-info m-2">

	<div class="card-header no-border">
		
		<h3 class="card-title">
			<i class="fas fa-th mr-1"></i>
			Línea de Reservas
		</h3>

	</div>

	<div class="card-body">
		
		<div class="chart" id="line-chart-ventas"></div>

	</div>

</div>

<script>

var line = new Morris.Line({
    element          : 'line-chart-ventas',
    resize           : true,
    data             : [

    <?php

    if($noRepetirFechas != null){

    	 foreach($noRepetirFechas as $key){

    	 	echo "{ y: '".$key."', ventas: ".$sumaPagosMes[$key]." },";

    	 }

    }else{

    	 echo "{ y: '0', ventas: '0' }";

    }

    ?>

    ],
    xkey             : 'y',
    ykeys            : ['ventas'],
    labels           : ['ventas'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits         : '$',
    gridTextSize     : 10

});



</script>