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
        $data = isset($_POST['data']) ? intval($_POST['data']) : 0;

        // Check if the values are not empty
        if (empty($name) || $year < 2000 || $year > 2023 || $data < 0) {
            echo "Error: Invalid input data";
        } else {
            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO counties (name, year, data) VALUES (:name, :year, :data)");

            // Bind parameters
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':data', $data, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            echo "Data inserted successfully!";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

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
                    <input type="number" name="data" class="form-control" required>
                </div>
                <button type="submit" name="submitUpload" class="btn btn-primary">Upload Data</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
