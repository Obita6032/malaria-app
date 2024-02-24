<?php
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $month = $_POST['month'];
    $cases = $_POST['cases'];

    try {
    
             // Check if the month already exists in the table
             $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM malaria2023 WHERE month = :month");
             $checkStmt->bindParam(':month', $month, PDO::PARAM_STR);
             $checkStmt->execute();
     
             $rowCount = $checkStmt->fetchColumn();
             if ($rowCount > 0) {
                // Month already exists, handle the situation accordingly
                echo "The data for this month already exists";
             }else{
                // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO malaria2023 (month, cases) VALUES (:month, :cases)");
    
            // Bind parameters
            $stmt->bindParam(':month', $month, PDO::PARAM_STR);
            $stmt->bindParam(':cases', $cases, PDO::PARAM_STR);
    
            // Execute the statement
            $stmt->execute();
    
            echo "Data inserted successfully!";
    
             }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

?>