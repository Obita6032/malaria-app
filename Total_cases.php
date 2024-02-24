<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total cases recorded</title>
    <link rel="stylesheet" href="line_chart_basic/style.css">
</head>
<body>
    <div class="Total_cases">
    <?php
// Include the connection file
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Prepare the SQL statement to calculate the sum of cases
    $stmt = $pdo->prepare("SELECT SUM(data) as total_cases FROM line_graph");

    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Display the total cases
    echo "Total Cases: " . $result['total_cases'];
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

    </div>
</body>
</html>