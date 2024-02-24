<?php
include 'config.php';

try {
    // Prepare the SQL statement to select data
    $stmt = $pdo->prepare("SELECT * FROM line_graph");

    // Execute the statement
    $stmt->execute();

    // Fetch all rows as an associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the data
   // echo "<h2>Retrieved Data:</h2>";
    //echo "<table border='1'>";
    //echo "<tr><th>Name</th><th>Data</th></tr>";

    foreach ($result as $row) {
       // echo "<tr><td>{$row['name']}</td><td>{$row['data']}</td></tr>";
    }

    // Convert the data to JSON
    $jsonData = json_encode($result);

    // Store the JSON data in a PHP array
    $dataArray = json_decode($jsonData, true);
    

    // Display the JSON data
    //echo "<h2>Retrieved Data (JSON):</h2>";
  //  echo "<pre>" . $jsonData . "</pre>";

    // Display the PHP array
   // echo "<h2>Retrieved Data (Array):</h2>";
    echo "<pre>";
 //   print_r($dataArray);
    echo "</pre>";


    echo "</table>";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
