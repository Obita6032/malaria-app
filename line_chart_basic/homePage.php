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

                  <script src="line_chart_basic/code/highcharts.js"></script>
                  <script src="line_chart_basic/code/modules/series-label.js"></script>
                  <script src="line_chart_basic/code/modules/exporting.js"></script>
                  <script src="line_chart_basic/code/modules/export-data.js"></script>
                  <script src="line_chart_basic/code/modules/accessibility.js"></script>

                  <script src="code/highcharts.js"></script>
                 <script src="line_chart_basic/code/highcharts-more.js"></script>
                  <script src="line_chart_basic/code/modules/exporting.js"></script>
                  <script src="line_chart_basic/code/modules/export-data.js"></script>
                   <script src="line_chart_basic/code/modules/accessibility.js"></script>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<script src="js/bootstrap.bundle.min.js"></script>
    <nav>
        <a onclick="scrollToSection('home')">Home</a>
        <a onclick="scrollToSection('cases')">Cases</a>
        <a onclick="scrollToSection('deaths')">Deaths</a>
        <a onclick="scrollToSection('vaccines')">Vaccines</a>
        <a onclick="scrollToSection('about')">About</a>
        <a onclick="scrollToSection('contact')">Contact</a>
    </nav>
    <div class="container-fluid">
    <div class="container text-center">
        <h1 style="text-align:center">Malaria cases in Kenya</h1>


        <div class="card" style="width: 40rem; height: 150px; margin-left: 30%; padding: left 40px; background:blue;">
 
         <div class="card-body">
         <h5 class="card-title">Card title</h5>
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
          <a href="#" class="btn btn-primary">Go somewhere</a>
           </div>
      </div>

        <div class="row row-cols-1 row-cols-md-2 g-4" style="">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Malaria Trend in Kenya</h5>
        <p class="card-text">Graph showing the trends in malaria in kenya</p>

        
       
        <div id="totalCasesChartContainer" style="height: 300px;"> </div>
        <?php //require'home/obita/Downloads/MALARIA_REPOSITORY/Total_cases.php' ?>
                        <?php require 'line_graph.php' ?>
                    </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Malaria Deaths</h5>
        <p class="card-text">Bar graph showing number of Deaths</p>
        <?php //require'/home/obita/Downloads/MALARIA_REPOSITORY/Total_cases2023.php'; ?>
        
                  <?php require'bar_graph.php'?>
    </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="..." class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">leading Counties.</p>
        <div id="kisiiChartContainer" style="height: 300px;"></div>
                        <?php //require '/home/obita/Downloads/MALARIA_REPOSITORY/line_chart_basic/kisiiCounty.php' ?>
                    </div>
    </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="..." class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</body>
</html>