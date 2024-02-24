<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Months with highest cases</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="Top_months">
    <?php
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Prepare the SQL statement to select the top 3 months with the highest cases
    $stmt = $pdo->prepare("SELECT month, cases FROM malaria2023 ORDER BY cases DESC LIMIT 3");

    // Execute the statement
    $stmt->execute();

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the results
    if (count($results) > 0) {
        echo "<h2>Top 3 Months with Highest Cases</h2>";
        echo "<ul>";
        foreach ($results as $result) {
            echo "<li>{$result['month']} - {$result['cases']} cases</li>";
        }
        echo "</ul>";
    } else {
        echo "No data found.";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

    </div>
    
</body>
</html>