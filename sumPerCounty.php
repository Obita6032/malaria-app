<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total cases recorded per County</title>
    <link rel="stylesheet" href="line_chart_basic/style.css">
</head>
<body>
    <div class="Total_cases_per_county">
    <?php
    // connection file
    include 'config.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    try {
        // SQL statement to calculate the sum of data per county
        $stmt = $pdo->prepare("SELECT name, SUM(data) as total_cases FROM line_graph GROUP BY name");

        
        $stmt->execute();

        // Fetch the results as an associative array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the total cases per county
        foreach ($results as $result) {
            echo "Total Cases in :" . $result['name'] . ": " . $result['total_cases'] . "<br>";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    ?>
    </div>
</body>
</html>
