<?php 
//session_start();
require_once('config.php');

include('retrieve_bar_data.php');
//check if $jsonData is not null before decoding
if ($jsonData !== null) {
    $dataArray = json_decode($jsonData, true);

    // Loop through each entry in the array and convert the "data" string to an array of numbers
    foreach ($dataArray as &$entry) {
    if(isset($entry['data'])){
        $entry['data'] = array_map('intval', explode(',', $entry['data']));


    }else{
        $entry['data']=[];
    }
    }

    $months = array_column($dataArray, 'month');
    $casesData = array_column($dataArray, 'cases');
} else {
    // Handle the case when $jsonData is null
    echo "Error: Unable to retrieve data.";
}

?>



<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>malaria Rate in the year 2023</title>

		<style type="text/css">
#container {
    height: 400px;
}

.highcharts-figure,
.highcharts-data-table table {
    min-width: 320px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

		</style>
	</head>
	<body>
<script src="code/highcharts.js"></script>
<script src="code/highcharts-more.js"></script>
<script src="code/modules/exporting.js"></script>
<script src="code/modules/export-data.js"></script>
<script src="code/modules/accessibility.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<figure class="highcharts-figure">
    <div id="container2"></div>
    <p class="highcharts-description">
       
    </p>

    <button id="plain">Plain</button>
    <button id="inverted">Inverted</button>
    <button id="polar">Polar</button>
</figure>




		<script type="text/javascript">
        const months = <?php echo json_encode($months);?>;
        const casesData =<?php echo json_encode($casesData)?>;
const chart = Highcharts.chart('container2', {
    title: {
        text: 'Reported malaria cases in kenya,2023',
        align: 'left'
    },
    subtitle: {
        text: 'Chart option: Plain | Source: ' +
            '<a href="https://www.nav.no/no/nav-og-samfunn/statistikk/arbeidssokere-og-stillinger-statistikk/helt-ledige"' +
            'target="_blank">NAV</a>',
        align: 'left'
    },
    colors: [
        '#4caefe',
        '#3fbdf3',
        '#35c3e8',
        '#2bc9dc',
        '#20cfe1',
        '#16d4e6',
        '#0dd9db',
        '#03dfd0',
        '#00e4c5',
        '#00e9ba',
        '#00eeaf',
        '#23e274'
    ],
    xAxis: {
        categories: months,  // ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
         title:{
            text: 'Months'
         }
    },
    series: [{
        type: 'column',
        name: 'malaria_2023',
        borderRadius: 5,
        colorByPoint: true,
        data: casesData,
        // [5412, 4977, 4730, 4437, 3947, 3707, 4143, 3609,
          //  3311, 3072, 2899, 2887],
        showInLegend: false
    }]
});

document.getElementById('plain').addEventListener('click', () => {
    chart.update({
        chart: {
            inverted: false,
            polar: false
        },
        subtitle: {
            text: 'Chart option: Plain | Source: ' +
                '<a href="https://www.nav.no/no/nav-og-samfunn/statistikk/arbeidssokere-og-stillinger-statistikk/helt-ledige"' +
                'target="_blank">NAV</a>'
        }
    });
});

document.getElementById('inverted').addEventListener('click', () => {
    chart.update({
        chart: {
            inverted: true,
            polar: false
        },
        subtitle: {
            text: 'Chart option: Inverted | Source: ' +
                '<a href="https://www.nav.no/no/nav-og-samfunn/statistikk/arbeidssokere-og-stillinger-statistikk/helt-ledige"' +
                'target="_blank">NAV</a>'
        }
    });
});

document.getElementById('polar').addEventListener('click', () => {
    chart.update({
        chart: {
            inverted: false,
            polar: true
        },
        subtitle: {
            text: 'Chart option: Polar | Source: ' +
                '<a href="https://www.nav.no/no/nav-og-samfunn/statistikk/arbeidssokere-og-stillinger-statistikk/helt-ledige"' +
                'target="_blank">NAV</a>'
        }
    });
});
		</script>
	</body>
</html>
