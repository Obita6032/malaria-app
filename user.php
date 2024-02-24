<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malaria Cases in Kenya</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Malaria Dashboard in Kenya</h1>
    </header>

    <nav>
        <a onclick="scrollToSection('home')">Home</a>
        <a onclick="scrollToSection('cases')">Cases</a>
        <a onclick="scrollToSection('deaths')">Deaths</a>
        <a onclick="scrollToSection('vaccines')">Vaccines</a>
        <a onclick="scrollToSection('about')">About</a>
        <a onclick="scrollToSection('contact')">Contact</a>
    </nav>

    <main>
    <section id="home">
            <h2>Home Section</h2>
            <!-- Content for the Home section -->
        </section>

        <section id="cases">
            <h2>Cases Section</h2>
            <!-- Content for the About section -->
            <?php 
           // include 'line_chart_basic/line_graph.php';
            ?>
            <?php 
session_start();
require_once('config.php');

include('retrievedata.php');
// Assuming $jsonData contains the provided data

$dataArray = json_decode($jsonData, true);

// Loop through each entry in the array and convert the "data" string to an array of numbers
foreach ($dataArray as &$entry) {
    $entry['data'] = array_map('intval', explode(',', $entry['data']));
}




?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Line Graph showing the malaria reportd cases in Kenya </title>

		<style type="text/css">
.highcharts-figure,
.highcharts-data-table table {
    min-width: 360px;
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
<script src="code/modules/series-label.js"></script>
<script src="code/modules/exporting.js"></script>
<script src="code/modules/export-data.js"></script>
<script src="code/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
        Basic line chart showing trends in malaria cases in Kenya. This chart includes the
        <code>series-label</code> module, which adds a label to each line for
        enhanced readability.
    </p>
</figure>





		<script type="text/javascript">
Highcharts.chart('container', {

    title: {
        text: 'Malaria cases in Kenya',
        align: 'left'
    },

    subtitle: {
        text: 'Ministry of Health. Source: <a href="https://www.moh.gov.sg//" target="_blank">MoH</a>.',
        align: 'left'
    },

    yAxis: {
        title: {
            text: 'Recorded Cases',
           
        },
      //  tickInterval: 10000,
    },
    

    xAxis: {
        accessibility: {
            rangeDescription: 'Range: 2010 to 2023'
        }
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            pointStart: 2000
        }
    },
    

    series: <?php echo json_encode($dataArray); ?>,

  

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});

		</script>
	</body>
</html>
        </section>

        <
        
        section id="deaths">
            <h2>Deaths Section</h2>
            
            
        </section>
        <section id="vaccines">
            <h2>Vaccines Section</h2>
            <!-- Content for the Home section -->
        </section>

        <section id="about">
            <h2>About Section</h2>
            <!-- Content for the About section -->
        </section>

        <section id="contact">
            <h2>Contact Section</h2>
            <!-- Content for the Contact section -->
        </section>
     
    </main>

    <script>
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                section.scrollIntoView({ behavior: 'smooth' });
            }
        }
    </script>
</body>
</html>

