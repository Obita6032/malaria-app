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
    <title>Malaria Cases in Kenya</title>
  
</head>
<body>
<script src="js/bootstrap.bundle.min.js"></script>
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

        <div class="cases">
            <h2>Malaria case trends in kenya per counties</h2>
            <!-- Content for the About section -->
            <?php 
            include 'line_graph.php';
            ?>
         


</div>

        <div class="row row-cols-1 row-cols-md-2 g-4">

        <div class="col">
    <div class="card">
      
    <div class="card-body">
    <h5 class="card-title">Kisii County</h5>
    <p class="card-text">Malaria cases trends in Kisii.</p>
    <div id="kisiiChartContainer" style="height: 300px;">
    <script src="code/highcharts.js"></script>
    <script src="code/modules/series-label.js"></script>
    <script src="code/modules/exporting.js"></script>
    <script src="code/modules/export-data.js"></script>
    <script src="code/modules/accessibility.js"></script>
    <?php require 'kisiiCounty.php'; ?>
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
  <div class="col">
    <div class="card">
      <img src="..." class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
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

        <section id="deaths">
            <h2>Number of deaths caused by malaria</h2>
          
          
          
          <?php 
            require 'bar_graph.php';
            ?>
            
            
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
        $(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
        // Load more content when nearing the bottom of the page
        loadMoreContent();
    }
});
    </script>
</body>
</html>

