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

if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
}
try {
  $logAction = "User accessed the admin page";
  $userId = $_SESSION['id']; 
  $logStmt = $pdo->prepare("INSERT INTO user_logs (user_id, action) VALUES (?, ?)");
  $logStmt->execute([$userId, $logAction]);
} catch (PDOException $e) {
  die("Error logging action: " . $e->getMessage());
}

// Create an instance of the Admin class
$admin = new Admin($pdo);


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
        <title>Admin Panel</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link href="css/styles.css" rel="stylesheet" />
           <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>

    <nav style=" height:50px;">
    <a href="cases.php">Home</a>
    <a href="cases.php">Cases</a>
    <a href="Deaths.php">Deaths</a>
    <a href="vaccines.php">Vaccines</a>
    <a href="">About</a>
    <a href="">Contact</a>
</nav>

        <script src="js/bootstrap.bundle.min.js"></script>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light"><a href="adminPage.php" style="font-size:30px">Dashboard</a></div>
                <div class="list-group list-group-flush">

                <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    User Management
  </button>
  <ul class="dropdown-menu dropdown-menu-dark">
    <li><a class="dropdown-item active" href="addUser.php" target="_parent">Add User</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="edit_user.php">Edit User</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="deleteUser.php">Delete User</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="userRoles.php">Manage User Roles</a></li>
  </ul>
</div>

<li><hr class="dropdown-divider"></li>
<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Data Management
  </button>
  <ul class="dropdown-menu dropdown-menu-dark">
    <li><a class="dropdown-item active"  href="line_chart_basic/uploadData.php">Upload Data</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item"  href="adminPage.php">View Data Trends</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item"  href="editData.php">Edit Data</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item"  href="deleteData.php">Delete Data</a></li>
  </ul>
</div>
<li><hr class="dropdown-divider"></li>

<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Notifications
  </button>
  <ul class="dropdown-menu dropdown-menu-dark">
    <li><a class="dropdown-item active" href="#">View Notifications</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#">Send Notifications</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#">Dekete Notifications</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#"></a></li>
  </ul>
</div>

<li><hr class="dropdown-divider"></li>


<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Settings
  </button>
  <ul class="dropdown-menu dropdown-menu-dark">
    <li><a class="dropdown-item active" href="changePassword.php">Change Password</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#">System Configuration</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#"></a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#"></a></li>
  </ul>
</div>

<li><hr class="dropdown-divider"></li>

<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Security
  </button>
  <ul class="dropdown-menu dropdown-menu-dark">
    <li><a class="dropdown-item active" href="accessPermisions.php">Access Control</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="userLogs.php">user Logs</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="accessPermisions.php">Access Permissions</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#"></a></li>
  </ul>
</div>

<li><hr class="dropdown-divider"></li>

<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Feedback and Surveys
  </button>
  <ul class="dropdown-menu dropdown-menu-dark">
    <li><a class="dropdown-item active" href="#">Surveys</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#">Users Feedback</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#"></a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#"></a></li>
  </ul>
</div>

<li><hr class="dropdown-divider"></li>
<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Support and Help
  </button>
  <ul class="dropdown-menu dropdown-menu-dark">
    <li><a class="dropdown-item active" href="#">Contact Support</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#">Users Feedback</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#"></a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#"></a></li>
  </ul>
</div>

<li><hr class="dropdown-divider"></li>


                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
               <div class="container-md">
               <a class="navbar-brand" href="#">Navbar</a>
               </div>
                
               <button type="button" class="btn btn-primary">
                     Notifications <span class="badge text-bg-secondary">4</span>
                </button>

                </nav>
              
                <!-- Page content-->
              <div class="container-fluid">
                <div class="container text-center">
       
                 <div class="row row-cols-1 row-cols-md-2 g-4">
  <div class="col">
    <div class="card">
      <div class="card-body" style=" width:400px; height:400px; bg:#fff">
        <h5 class="card-title">malaria cases 2000-2010</h5>
         <?php require'Total_cases.php'?>
        <script src="line_chart_basic/code/highcharts.js"></script>
                 <script src="line_chart_basic/code/modules/series-label.js"></script>
                  <script src="line_chart_basic/code/modules/exporting.js"></script>
                  <script src="line_chart_basic/code/modules/export-data.js"></script>
                  <script src="line_chart_basic/code/modules/accessibility.js"></script>
                  <?php require'line_chart_basic/line_graph.php'?>
    </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Malaria Deaths</h5>
        <?php require'Total_cases2023.php'; ?>
        <<script src="code/highcharts.js"></script>
<script src="line_chart_basic/code/highcharts-more.js"></script>
<script src="line_chart_basic/code/modules/exporting.js"></script>
<script src="line_chart_basic/code/modules/export-data.js"></script>
<script src="line_chart_basic/code/modules/accessibility.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                  <?php require'line_chart_basic/bar_graph.php'?>
    
    </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="..." class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
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
        </div>
        
    </body>
</html>
