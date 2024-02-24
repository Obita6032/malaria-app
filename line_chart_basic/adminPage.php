<?php

session_start();
require_once('config.php');
require_once('Admin_operations.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check if the user is logged in and has admin access
if (!isset($_SESSION['email']) || $_SESSION['access_level'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Create an instance of the Admin class
$admin = new Admin($pdo);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PANEL</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-body">
<div class="sidenav">
    <a href="#section1">Dasboard</a>
    <div class="dropdown">
         <a href="#section3" class="dropbtn">Data Management </a>
         <div class="dropdown-content">
            <a href="#Add User">Upload new data</a>
            <a href="#Editt User">Edit existing Data</a>
            <a href="#Remove User">Remove Existing data</a>
        </div>
      </div>

         <div class="dropdown">
         <a href="#section3" class="dropbtn">User Management </a>
         <div class="dropdown-content">
            <a href="#Add User">Add User</a>
            <a href="#Editt User">Edit User</a>
            <a href="#Remove User">Remove User</a>
        </div>
      </div>

         <div class="dropdown">
         <a href="#section3" class="dropbtn">View Reports</a>
         <div class="dropdown-content">
            <a href="#Add User">view trends</a>
            <a href="#Editt User"></a>
            <a href="#Remove User">View data Reports</a>

        </div>
         </div>


         <div class="dropdown">
         <a href="#section3" class="dropbtn">Notifications</a>
         <div class="dropdown-content">
            <a href="#Add User">View Notifications</a>
            <a href="#Editt User">Delete Notifications</a>
            <a href="#Remove User">Send a Notifications</a>

        </div>
         
         </div>
    
    <div class="dropdown">
    <a href="#section3" class="dropbtn">Settings</a>
    <div class="dropdown-content">
            <a href="#Add User">Change password</a>
            <a href="#Editt User">System Settings</a>
            

        </div>
   </div>


   <div class="dropdown">
    <a href="#section3" class="dropbtn">Support</a>
    <div class="dropdown-content">
            <a href="#Add User">Request Support</a>
         

        </div>
</div>
<div class="dropdown">
    <a href="#section3" class="dropbtn">Feedback</a>
    <div class="dropdown-content">
            <a href="#Add User">Give Feedback</a>
            

        </div>
</div>
</div>

<section id="line-graph">

<script src="line_chart_basic/code/highcharts.js"></script>
<script src="line_chart_basic/code/modules/series-label.js"></script>
<script src="line_chart_basic/code/modules/exporting.js"></script>
<script src="line_chart_basic/code/modules/export-data.js"></script>
<script src="line_chart_basic/code/modules/accessibility.js"></script>
                    
    <?php 
//require 'line_insert.php';
//require 'line_chart_basic/line_form.php';
require 'line_chart_basic/line_graph.php';
?>


</div>
</body>
</html>