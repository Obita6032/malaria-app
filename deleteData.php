<?php
// Include the connection file
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to fetch all data from line_graph table
function fetchAllLineGraphData($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM line_graph");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch data by ID
function fetchDataById($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM line_graph WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Check if the form is submitted for deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitDelete'])) {
    try {
        $deleteIds = isset($_POST['deleteIds']) ? $_POST['deleteIds'] : '';

        // Explode the input into an array of IDs
        $idsArray = explode(',', $deleteIds);

        // Fetch data for the specified IDs
        $dataToDelete = [];
        foreach ($idsArray as $id) {
            $data = fetchDataById($pdo, $id);
            if ($data) {
                $dataToDelete[] = $data;
            }
        }

        // Delete the data if it exists
        if (!empty($dataToDelete)) {
            $deleteStmt = $pdo->prepare("DELETE FROM line_graph WHERE id IN (" . implode(',', array_fill(0, count($dataToDelete), '?')) . ")");
            $deleteStmt->execute($idsArray);
            echo "Data deleted successfully";
        } else {
            echo "No data found for the specified IDs";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Fetch all data for displaying in the table
$allLineGraphData = fetchAllLineGraphData($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body class="bg-dark">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center mb-4">Delete Data</h1>

            <!-- Display all data in a table for reference -->
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Data</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($allLineGraphData as $data) : ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['name']; ?></td>
                        <td><?php echo $data['data']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Form for deleting data -->
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="deleteIds">Enter IDs to Delete (comma-separated):</label>
                    <input type="text" name="deleteIds" class="form-control" required>
                </div>
                <button type="submit" name="submitDelete" class="btn btn-danger">Delete Data</button>
            </form>
            <p class="mt-3">
                <a href="adminPage.php" class="btn btn-secondary">Go Back to Dashboard</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
