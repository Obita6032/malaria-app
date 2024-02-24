<?php

include 'config.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve data from the database
$stmt = $pdo->prepare("SELECT * FROM malaria_deaths");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Organize data into an array by county
$countyData = array();

foreach ($data as $row) {
    $countyName = strtolower($row['county_name']);
    $year = $row['year'];
    $deathsCount = intval($row['deaths_count']);

    // Create or update the series for the county
    if (!isset($countyData[$countyName])) {
        $countyData[$countyName] = array('name' => ucfirst($countyName), 'data' => array(), 'type' =>'line');
    }

    // Add data point to the series
    $countyData[$countyName]['data'][] = array('x' => $year, 'y' => $deathsCount);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malaria Deaths Data</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
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

<nav style=" height:50px;">
    <a href="cases.php">Home</a>
    <a href="cases.php">Cases</a>
    <a href="Deaths.php">Deaths</a>
    <a href="vaccines.php">Vaccines</a>
    <a href="">About</a>
    <a href="">Contact</a>

    <h2>Malaria Deaths Data by County</h2>

    <?php if (!empty($data)): ?>
        <table border="1">
            <thead>
                <tr>
                   <th>County</th> 
                    <th>County Name</th>
                     <th>Deaths Count</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['county_name']; ?></td>
                        <td><?php echo $row['deaths_count']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No malaria deaths data available.</p>
    <?php endif; ?>

    <script src="code/highcharts.js"></script>
    <script src="code/modules/series-label.js"></script>
    <script src="code/modules/exporting.js"></script>
    <script src="code/modules/export-data.js"></script>
    <script src="code/modules/accessibility.js"></script>

    <figure class="highcharts-figure">
        <div id="container1" style="height: 400px;"></div>
        <p class="highcharts-description">
            Basic line chart showing trends in malaria deaths in Kenya.
        </p>
    </figure>

    <script type="text/javascript">
        Highcharts.chart('container1', {

            title: {
                text: 'Malaria Deaths in Kenya',
                align: 'left'
            },

            subtitle: {
                text: 'Ministry of Health. Source: <a href="https://www.moh.gov.sg//" target="_blank">MoH</a>.',
                align: 'left'
            },

            yAxis: {
                title: {
                    text: 'Recorded deaths',
                },
            },
            
            xAxis: {
                accessibility: {
                    rangeDescription: 'Range: 20 to 2023'
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
                    connectNulls: true
                }
            },
            
            series: <?php echo json_encode(array_values($countyData)); ?>,

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
