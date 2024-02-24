<?php
// Include the connection file
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $data = $_POST['data'];


    try {
        // Check if the County already exists in the table
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM line_graph WHERE name = :name");
        $checkStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $checkStmt->execute();

        $rowCount = $checkStmt->fetchColumn();
        if ($rowCount > 0) {
           // Month already exists, handle the situation accordingly
           echo "The data for this County already exists";
        }else{
           // Prepare the SQL statement
       $stmt = $pdo->prepare("INSERT INTO line_graph (name, data) VALUES (:name, :data)");

       // Bind parameters
       $stmt->bindParam(':name', $name, PDO::PARAM_STR);
       $stmt->bindParam(':data', $data, PDO::PARAM_STR);

       // Execute the statement
       $stmt->execute();

       echo "Data inserted successfully!";
    } }
      catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>