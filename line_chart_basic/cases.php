<?php
require_once('config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malaria Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <style>
        #totalCasesChartContainer,
#deathsChartContainer,
#kisiiChartContainer {
    margin-bottom: 20px; 
}

.card-body {
    padding: 10px; 
}
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="line_chart_basic/code/highcharts.js"></script>
    <script src="line_chart_basic/code/modules/series-label.js"></script>
    <script src="line_chart_basic/code/modules/exporting.js"></script>
    <script src="line_chart_basic/code/modules/export-data.js"></script>
    <script src="line_chart_basic/code/modules/accessibility.js"></script>

 
</head>
<body>
<script src="js/bootstrap.bundle.min.js"></script>
    <nav style=" height:50px;">
    <a href="cases.php">Home</a>
    <a href="cases.php">Cases</a>
    <a href="">Deaths</a>
    <a href="vaccines.php">Vaccines</a>
    <a href="surveyForm.php">Survey</a>
    <a href="">About</a>
    <a href="">Contact</a>
    
       <!-- <a onclick="scrollToSection('home')">Home</a>
        <a onclick="scrollToSection('cases')">Cases</a>
        <a onclick="scrollToSection('deaths')">Deaths</a>
        <a onclick="scrollToSection('vaccines')">Vaccines</a>
        <a onclick="scrollToSection('about')">About</a>
        <a onclick="scrollToSection('contact')">Contact</a>
        <a href="vaccines.php">vaccines</a>
-->
    </nav>
    <div class="container-fluid">
    <div class="container text-center">
        <h1 style="text-align:center; font: size 50px;height:20%;" >Malaria cases in Kenya</h1>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col mb-3">
                <div class="card" style="padding-top:50px; top:10%; left:50%; background:#fff;">
           
                 <p class="card-header" style="background:#333; color:white; height:100px; margin-left:10px; font-family:  monospace;font-size: 25px;  font-weight: bold; ">Ministry of Health Malaria Dashboard</p>
                 
                 <div class="card-body">

                     
<!--
                    <div class="card" style="width: 30rem; padding:left 30px; height:30rem;">
  <img src="images/mosquito.jpg" class="card-img-top" alt="Mosquito">
  <div class="card-body">
    <h5 class="card-title">Malaria Cases, County Trends</h5>
    <p class="card-text">Leading Counties with Malaria Cases</p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">An item</li>
    <li class="list-group-item">A second item</li>
    <li class="list-group-item">A third item</li>
  </ul>
  <div class="card-body">
    <a href="kisiiCounty.php" class="card-link">Card link</a>
    <a href="kisiiCounty.php"  class="card-link">kisii</a>
    <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    County
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="kisiiCounty.php">Kisii</a></li>
    <li><a class="dropdown-item" href="homabayCounty.php">Homabay</a></li>
    <li><a class="dropdown-item" href="kisumuCounty.php">Kisumu</a></li>
  </ul>
</div>
  </div>
</div> -->



                        <h5 class="card-title">Malaria Trend in Kenya</h5>
                        
                     
<?php



try {
    // Retrieve data from line_graph table
    $fetchStmt = $pdo->prepare("SELECT * FROM line_graph");
    $fetchStmt->execute();
    $dataRows = $fetchStmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($dataRows)) {
        echo "No data found in line_graph table";
    } else {
        // Calculate the sum
        $sum = 0;

        foreach ($dataRows as $row) {
            $sum += intval($row['data']);
        }

        // Calculate the absolute difference between each county and the sum
        $countiesDifference = [];

        foreach ($dataRows as $row) {
            $countyName = $row['name'];
            $countyData = intval($row['data']);
            $absoluteDifference = abs($countyData - $sum);
            $countiesDifference[$countyName] = $absoluteDifference;
        }

        // Display the sum and differences in a table
        echo '<table border="1">';
        echo '<tr><th>County Name</th><th>Data</th></tr>';

        // Display sum row
        echo '<tr><td><strong>Total Sum</strong></td><td>' . $sum . '</td></tr>';

        // Display absolute differences rows
        foreach ($countiesDifference as $countyName => $absoluteDifference) {
            echo '<tr><td>' . $countyName . '</td><td>' . $absoluteDifference . '</td></tr>';
        }

        echo '</table>';
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}



try {
    // Retrieve data from line_graph table
    $fetchStmt = $pdo->prepare("SELECT * FROM line_graph ORDER BY data ASC");
    $fetchStmt->execute();
    $dataRows = $fetchStmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($dataRows)) {
        echo "No data found in line_graph table";
    } else {
        // Start the div with styling to align it to the right
        echo '<div style="float: right; width:95%; margin: 10px; padding: 10px; border: 1px solid #000;">';

        // Find the maximum value for scaling
        $maxValue = max(array_column($dataRows, 'data'));
        
 
        // Display the data in a table with a colored bar for each county
        echo '<table border="1" cellpadding="5" cellspacing="0">';
        echo '<tr><th>County</th><th>Data</th><th></th></tr>';

        foreach ($dataRows as $row) {
            $countyName = $row['name'];
            $countyData = intval($row['data']); // Explicitly cast to integer

            // Define colors for the bars (you can customize these)
            $barColor = '#' . substr(md5($countyName), 0, 6);

            echo '<tr>';
            echo '<td>' . $countyName . '</td>';
            echo '<td>' . $countyData . '</td>';
            
            // Scale the bar width based on a percentage of the maximum value
            $scaledWidth = $countyData/20 ; //(($countyData /100)*100);
            echo '<td style="background-color:' . $barColor . '; width:' . $scaledWidth . '80%;">&nbsp;</td>';
            
            echo '</tr>';
        }

        echo '</table>';

        // Close the div
        echo '</div>';
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
                        <div class="Total-cases"> <?php //require '/home/obita/Downloads/MALARIA_REPOSITORY/Total_cases.php' ?> </div>
                    <div id="totalCasesChartContainer" style="height: 300px;"></div>
                    <p class="card-text" style="text-align:center; height:10px;">Graph showing the trends in malaria in Kenya</p>
                        <script>
                            $(document).ready(function () {
                                Highcharts.chart('totalCasesChartContainer', {

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

              
                                
                            });
                        </script>
                        <?php require 'line_graph.php' ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Malaria Deaths</h5>
                        <p class="card-text">Bar graph showing the number of Deaths</p>
                       
                        <div id="deathsChartContainer" style="height: 300px;"></div>
                        <script>
                            $(document).ready(function () {
                                // Initialize the chart here
                                Highcharts.chart('deathsChartContainer', {

                                  
                                });
                            });
                        </script>
                        <?php require 'bar_graph.php' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
