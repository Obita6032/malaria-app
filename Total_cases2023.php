<?php
// Include the connection file
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Cases</title>
   
<body>
    <div class="cases_2023">
        <?php
        try {
            // Prepare the SQL statement to calculate the sum of cases
            $stmt = $pdo->prepare("SELECT SUM(cases) as total_cases FROM malaria2023");

            // Execute the statement
            $stmt->execute();

            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Display the total cases
            echo "Total Cases: " . $result['total_cases'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>
