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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="line_chart_basic/style.css">
    
</head>
<body>

<nav>
    <div class="sidebar">
        <a onclick="scrollToSection('home')">Home</a>
        <a onclick="scrollToSection('Add-users')">Create user</a>
        <a onclick="scrollToSection('Update-user')">update user Details</a>
        <a onclick="scrollToSection('Delete-user')">Delete User</a>
        <a onclick="scrollToSection('about')">About</a>
        <a onclick="scrollToSection('contact')">Contact</a>
        <a onclick="scrollToSection('more')">More</a>
</div>


        
    </nav>

    <div class="main-body">
        <main>
        

    <h1>Create a new User</h1>

    <!-- HTML form for creating a new user -->
    <section id ="Add-users">
    <div class="form-section">
        <div class="createuser">
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-group">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" placeholder="Enter First Name" required class="form-control" value="<?php echo ($valFirstName ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" placeholder="Enter Last Name" required class="form-control" value="<?php echo ($valLastName ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="county">County:</label>
        <input type="text" name="county" placeholder="Enter County" required class="form-control" value="<?php echo ($valCounty ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="access_level">Access Level:</label>
        <input type="text" name="access_level" placeholder="Enter Access Level" required class="form-control" value="<?php echo ($valAccessLevel ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" name="email" placeholder="Enter Email" required class="form-control" value="<?php echo ($valEmail ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Enter Password" required class="form-control" value="<?php echo ($valPassword ?? ''); ?>">
    </div>
    <button type="submit" id="createButton" name="createUser" class="btn btn-primary">Create User</button>

</form>
</div>
</div>
</section>

<!-- HTML form for updating a user -->
<h1>Update user details</h1>
    <section id ="Update-user">
    <div class="form-section">
        <div class="updateUser">    
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="id">Enter User ID to Update:</label>
    <input type="text" name="id" required>

    <div class="form-group">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" placeholder="Enter First Name" class="form-control" value="<?php echo ($valFirstName ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" placeholder="Enter Last Name" class="form-control" value="<?php echo ($valLastName ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="county">County:</label>
        <input type="text" name="county" placeholder="Enter County" class="form-control" value="<?php echo ($valCounty ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="access_level">Access Level:</label>
        <input type="text" name="access_level" placeholder="Enter Access Level" class="form-control" value="<?php echo ($valAccessLevel ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" name="email" placeholder="Enter Email" class="form-control" value="<?php echo ($valEmail ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Enter New Password" class="form-control">
    </div>

    <button type="submit" id="updateButton" name="updateUser" class="btn btn-primary">Update User</button>



</form>
</div>
</div>
</section>

<!-- HTML form for deleting a user -->
<h1>Delete User</h1>
    <section id="Delete-user">
         <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
           <label for="id">Enter User ID to Delete: </label>
        <input type="text" name="id" required>
        <button id="deleteButton"   type="submit" name="deleteUser">Delete User</button>

         </form>

    </section>

    <section id="delete-cases">
        <h1>delete cases Records</h1>
        <?php 
        include 'line_chart_basic/delete_cases_data.php';
        ?>
    </section>

   







  <?php 

  // Handle form submissions
if (isset($_POST['createUser'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $county = $_POST['county'];
    $access_level = $_POST['access_level'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $admin=new Admin($pdo);

    $admin->createUser($firstName, $lastName, $county, $access_level, $password, $email);
}

if (isset($_POST['updateUser'])) {
    $id = $_POST['id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $county = $_POST['county'];
    $access_level = $_POST['access_level'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    $admin->updateUser($id, $firstName, $lastName, $county, $access_level, $email,$password);
}

if (isset($_POST['deleteUser'])) {
    $id = $_POST['id'];

    $admin->deleteUser($id);
}

// Display users
$users = $admin->getUsers();
foreach ($users as $user) {
  //  echo "ID: {$user['id']}, FirstName: {$user['first_name']}, LastName: {$user['last_name']}, County: {$user['county']}, Access_level: {$user['access_level']}<br>";
}


// Retrieve line graph data
try {
    $lineGraphData = $pdo->query("SELECT * FROM line_graph")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
  
  ?>
  





    
    <section id="lineGraph">
            <h2>Line Graph Data Table</h2>

            <button id="toggleLineGraph" onclick="toggleTable('lineGraphTable')">Toggle Line Graph Table</button>

            <div id="lineGraphTable">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lineGraphData as $row): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['data']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>


        </section >
      


?>

    </main>
    </div>
   
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

function toggleTable() {
            // Get the table container element
            var tableContainer = document.getElementById('table-container');

            // Toggle the display property of the table container
            if (tableContainer.style.display === 'none' || tableContainer.style.display === '') {
                tableContainer.style.display = 'block';
            } else {
                tableContainer.style.display = 'none';
            }
        }

        //edit users

        function toggleTable(tableId) {
            var table = document.getElementById(tableId);

            if (table.style.display === 'none' || table.style.display === '') {
                table.style.display = 'block';
            } else {
                table.style.display = 'none';
            }
        }



        document.addEventListener("DOMContentLoaded", function () {
        // Function to hide create user, update user, and delete user sections
        function hideSections() {
            document.getElementById('Add-users').style.display = 'none';
            document.getElementById('Update-user').style.display = 'none';
            document.getElementById('Delete-user').style.display = 'none';
        }

        // Call the function to hide sections on page load
        hideSections();

        // Function to toggle display of sections
        function toggleSection(sectionId) {
            hideSections();
            document.getElementById(sectionId).style.display = 'block';
        }

        // Add click event listeners to the corresponding buttons
        document.getElementById('createButton').addEventListener('click', function () {
            toggleSection('Add-users');
        });

        document.getElementById('updateButton').addEventListener('click', function () {
            toggleSection('Update-user');
        });

        document.getElementById('deleteButton').addEventListener('click', function () {
            toggleSection('Delete-user');
        });
    });
    </script>

<section id="line-graph">

<script src="line_chart_basic/code/highcharts.js"></script>
<script src="line_chart_basic/code/modules/series-label.js"></script>
<script src="line_chart_basic/code/modules/exporting.js"></script>
<script src="line_chart_basic/code/modules/export-data.js"></script>
<script src="line_chart_basic/code/modules/accessibility.js"></script>
                    
    <?php 
//require 'line_insert.php';
require 'line_chart_basic/line_form.php';
require 'line_chart_basic/line_graph.php';
?>

</section>

<section id="bar-graph">
<script src="line_chart_basic/code/highcharts.js"></script>
<script src="line_chart_basic/code/modules/series-label.js"></script>
<script src="line_chart_basic/code/modules/exporting.js"></script>
<script src="line_chart_basic/code/modules/export-data.js"></script>
<script src="line_chart_basic/code/modules/accessibility.js"></script>
    <?php
    require 'line_chart_basic/bar_graph.php';
    
    ?>
</section>



   
</body>
</html>

