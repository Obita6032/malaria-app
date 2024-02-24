<?php
// Include the connection file
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to fetch all data from line_graph table for a specific county
function fetchLineGraphData($pdo, $name)
{
    $stmt = $pdo->prepare("SELECT * FROM line_graph WHERE name = :name");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch data for a specific year and county
function fetchDataForYear($pdo, $name, $year)
{
    $stmt = $pdo->prepare("SELECT * FROM line_graph WHERE name = :name AND YEAR(data) = :year");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Check if the form is submitted for editing
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitEdit'])) {
    try {
        $editedData = isset($_POST['editedData']) ? trim($_POST['editedData']) : '';
        $editId = isset($_POST['editId']) ? $_POST['editId'] : '';

        // Update the existing data
        $updateStmt = $pdo->prepare("UPDATE line_graph SET data = :editedData WHERE id = :id");
        $updateStmt->bindParam(':id', $editId, PDO::PARAM_INT);
        $updateStmt->bindParam(':editedData', $editedData, PDO::PARAM_STR);
        $updateStmt->execute();

        echo "Data updated successfully";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Check if the form is submitted for deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitDelete'])) {
    try {
        $deleteId = isset($_POST['deleteId']) ? $_POST['deleteId'] : '';

        // Delete the data
        $deleteStmt = $pdo->prepare("DELETE FROM line_graph WHERE id = :id");
        $deleteStmt->bindParam(':id', $deleteId, PDO::PARAM_INT);
        $deleteStmt->execute();

        echo "Data deleted successfully";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}


// Check if the form is submitted for adding new data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitAdd'])) {
    try {
        $newData = isset($_POST['newData']) ? $_POST['newData'] : [];
        $countyName = isset($_POST['countyName']) ? trim($_POST['countyName']) : '';

        // Check if data for the county already exists
        $existingDataStmt = $pdo->prepare("SELECT COUNT(*) FROM line_graph WHERE name = :name");
        $existingDataStmt->bindParam(':name', $countyName, PDO::PARAM_STR);
        $existingDataStmt->execute();

        $existingRowCount = $existingDataStmt->fetchColumn();

        if ($existingRowCount > 0) {
            // Data for the county already exists, handle it accordingly
            echo "Data for the county already exists. You can edit existing data.";
        } else {
            // Insert new data for each year
            foreach ($newData as $year => $data) {
                // Skip if data is not provided
                if (empty($data)) {
                    continue;
                }

                // Insert new data
                $insertStmt = $pdo->prepare("INSERT INTO line_graph (name, data) VALUES (:name, :data)");
                $insertStmt->bindParam(':name', $countyName, PDO::PARAM_STR);
                $insertStmt->bindParam(':data', $data, PDO::PARAM_STR);
                $insertStmt->execute();
            }

            echo "New data inserted successfully";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Fetch data for the specified county
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitCounty'])) {
    $name = isset($_POST['countyName']) ? trim($_POST['countyName']) : '';
} else {
    $name = '';
}

// Fetch data for each year
$lineGraphData = [];
for ($year = 2000; $year <= 2023; $year++) {
    $lineGraphData[$year] = fetchDataForYear($pdo, $name, $year);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View and Edit Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body class="bg-dark">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center mb-4">View and Edit Data</h1>

            <!-- Form for entering the county name -->
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="countyName">Enter County Name:</label>
                    <input type="text" name="countyName" class="form-control">
                </div>
                <button type="submit" name="submitCounty" class="btn btn-primary">Submit</button>
            </form>

            <?php if ($name) : ?>
                <!-- Display data in table for the specified county -->
                <table class="table table-bordered mt-4">
                    <thead>
                    <tr>
                        <th>Year</th>
                        <th>Data</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($lineGraphData as $year => $data) : ?>
                        <tr>
                            <td><?php echo $year; ?></td>
                            <td>
                                <?php if ($data) : ?>
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <input type="hidden" name="editId" value="<?php echo $data['id']; ?>">
                                        <input type="text" name="editedData" value="<?php echo $data['data']; ?>" class="form-control">
                                        <button type="submit" name="submitEdit" class="btn btn-primary">Edit</button>
                                    </form>
                                <?php else : ?>
                                    <em>No data available</em>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($data) : ?>
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <input type="hidden" name="deleteId" value="<?php echo $data['id']; ?>">
                                        <button type="submit" name="submitDelete" class="btn btn-danger">Delete</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Form for adding new data -->
                <h2 class="text-center mb-4">Add New Data</h2>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <label for="countyName">Select County:</label>
                        <select name="countyName" class="form-control">
                            <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
                        </select>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Year</th>
                            <th>Data</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($lineGraphData as $year => $data) : ?>
                            <tr>
                                <td><?php echo $year; ?></td>
                                <td>
                                    <?php if ($data) : ?>
                                        <em>Data already exists</em>
                                    <?php else : ?>
                                        <input type="text" name="newData[<?php echo $year; ?>]" class="form-control">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!$data) : ?>
                                        <button type="submit" name="submitAdd" class="btn btn-success">Add Data</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
                <p class="mt-3">
                <a href="adminPage.php" class="btn btn-secondary">Dashboard</a>
            </p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
