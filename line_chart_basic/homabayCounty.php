<?php
require_once('config.php');

// Fetch data from the database for Homabay County
$sql = 'SELECT name, year, data FROM counties WHERE name = :countyName';
$countyName = 'Homabay'; // Specify the county name
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':countyName', $countyName, PDO::PARAM_STR);
$stmt->execute();
$resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Organize data for the chart
$countyData = [];
foreach ($resultSet as $row) {
    $countyName = $row['name'];
    $year = $row['year'];
    $data = intval($row['data']);

    if (!isset($countyData[$countyName])) {
        $countyData[$countyName] = ['name' => $countyName, 'data' => []];
    }

    $countyData[$countyName]['data'][] = $data;
}

// Convert data to Highcharts format
$chartData = array_values($countyData);

// Close the database connection
$pdo = null;
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Line Graph showing Malaria Cases in Homabay</title>

    <style type="text/css">
        /* Add your CSS styles here if needed */
    </style>
</head>
<body>

<script src="code/highcharts.js"></script>
<script src="code/modules/series-label.js"></script>
<script src="code/modules/exporting.js"></script>
<script src="code/modules/export-data.js"></script>
<script src="code/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container1" style="height: 400px;"></div>
    <p class="highcharts-description">
        Line chart showing trends in malaria cases in Homabay County.
    </p>
</figure>

<script type="text/javascript">
    Highcharts.chart('container1', {
        title: {
            text: 'Malaria Cases in Homabay County',
            align: 'left'
        },
        subtitle: {
            text: 'Ministry of Health. Source: <a href="https://www.moh.gov.sg//" target="_blank">MoH</a>.',
            align: 'left'
        },
        yAxis: {
            title: {
                text: 'Recorded Cases'
            },
        },
        xAxis: {
            accessibility: {
                rangeDescription: 'Range: 2000 to 2023'
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
        series: <?php echo json_encode($chartData); ?>,
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
