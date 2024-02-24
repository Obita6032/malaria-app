<?php
session_start();
require_once('config.php');
require_once('Admin_operations.php');

// Check if the user is logged in and has admin access
if (!isset($_SESSION['email']) || $_SESSION['access_level'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Create an instance of the Admin class
$admin = new Admin($pdo);

// Retrieve user logs from the database
try {
    $fetchLogsStmt = $pdo->prepare("SELECT * FROM user_logs ORDER BY log_time DESC");
    $fetchLogsStmt->execute();
    $logs = $fetchLogsStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>User Logs</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <!-- Your existing HTML structure -->
    <nav style=" height:50px;">
        <a href="adminPage.php">Home</a>
       
    </nav>

    <div class="d-flex" id="wrapper">
    
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Page content-->
            <div class="container-fluid">
                <h2>User Logs</h2>

                <?php if (!empty($logs)) : ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Log ID</th>
                                <th>User ID</th>
                                <th>Action</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log) : ?>
                                <tr>
                                    <td><?php echo $log['log_id']; ?></td>
                                    <td><?php echo $log['user_id']; ?></td>
                                    <td><?php echo $log['action']; ?></td>
                                    <td><?php echo $log['log_time']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No user logs available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="line_chart_basic/code/highcharts.js"></script>

</body>

</html>