<?php
// Include the connection file
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitUpload'])) {

    // Retrieve form data
    try {
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $year = isset($_POST['year']) ? intval($_POST['year']) : 0;
        $data = isset($_POST['data']) ? trim($_POST['data']) : '';

        // Check if the values are not empty
        if (empty($name) || empty($data) || $year < 2000 || $year > 2023) {
            echo "Error: Invalid input data";
        } else {
            // Check if the county name already exists in the table
            $checkCountyStmt = $pdo->prepare("SELECT COUNT(*) FROM line_graph WHERE name = :name");
            $checkCountyStmt->bindParam(':name', $name, PDO::PARAM_STR);
            $checkCountyStmt->execute();

            $rowCount = $checkCountyStmt->fetchColumn();
            if ($rowCount > 0) {
                // County name already exists, handle the situation accordingly
                echo "The data for this County already exists";
            } else {
                // Prepare the SQL statement
                $stmt = $pdo->prepare("INSERT INTO line_graph (name, data) VALUES (:name, :data)");

                // Bind parameters
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':data', $data, PDO::PARAM_STR);

                // Execute the statement
                $stmt->execute();

                echo "Data inserted successfully!";
            }
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!-- Rest of your HTML code remains unchanged -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Upload Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body class="bg-dark">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center mb-4">Admin Upload Data</h1>

            <!-- Form for uploading data -->
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="name">County Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="year">Year (2000 - 2023):</label>
                    <input type="number" name="year" class="form-control" min="2000" max="2023" required>
                </div>
                <div class="form-group">
                    <label for="data">Data:</label>
                    <input type="text" name="data" class="form-control" required>
                </div>
                <button type="submit" name="submitUpload" class="btn btn-primary">Upload Data</button>
            </form>
            <p class="mt-3">
                <a href="adminPage.php" class="btn btn-secondary">Go Back to Dashboard</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
