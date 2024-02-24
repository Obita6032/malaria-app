<?php
// Include the connection file
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitLine'])) {

    // Retrieve form data
    try {
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $data = isset($_POST['data']) ? $_POST['data'] : '';

        // Check if the values are not empty
        if (empty($name) || empty($data)) {
            echo "Error: Name and Data are required";
        } else {
            // Check if the County already exists in the table
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM line_graph WHERE name = :name");
            $checkStmt->bindParam(':name', $name, PDO::PARAM_STR);
            $checkStmt->execute();

            $rowCount = $checkStmt->fetchColumn();
            if ($rowCount > 0) {
                // County data already exists
                echo "The data for this County already exists";
                echo '<br><a href="'.$_SERVER['PHP_SELF'].'?edit=true">Click here to edit existing data</a>';
            } else {
                // Insert data for each year
                foreach ($data as $year => $value) {
                    // Trim each value
                    $trimmedValue = trim($value);

                    // Check if data for the year already exists
                    $yearCheckStmt = $pdo->prepare("SELECT COUNT(*) FROM line_graph WHERE name = :name AND year(data) = :year");
                    $yearCheckStmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $yearCheckStmt->bindParam(':year', $year, PDO::PARAM_INT);
                    $yearCheckStmt->execute();

                    $yearRowCount = $yearCheckStmt->fetchColumn();
                    if ($yearRowCount == 0) {
                        // Prepare the SQL statement
                        $stmt = $pdo->prepare("INSERT INTO line_graph (name, data) VALUES (:name, :data)");
                        // Bind parameters
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                        $stmt->bindParam(':data', $trimmedValue, PDO::PARAM_STR);
                        // Execute the statement
                        $stmt->execute();
                        echo "Data inserted successfully for year $year<br>";
                    } else {
                        echo "Data for year $year already exists";
                        echo '<br><a href="'.$_SERVER['PHP_SELF'].'?edit=true&year='.$year.'">Click here to edit existing data for '.$year.'</a>';
                    }
                }
            }
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Check if the edit parameter is set in the URL
if (isset($_GET['edit']) && $_GET['edit'] == true) {
    // Display a form for editing existing data
    $editYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
    $editStmt = $pdo->prepare("SELECT data FROM line_graph WHERE name = :name AND year(data) = :year");
    $editStmt->bindParam(':name', $name, PDO::PARAM_STR);
    $editStmt->bindParam(':year', $editYear, PDO::PARAM_INT);
    $editStmt->execute();
    $existingData = $editStmt->fetch(PDO::FETCH_ASSOC);

    if ($existingData) {
        // Display the edit form
        echo '<br><h3>Edit Data for Year '.$editYear.'</h3>';
        echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
        echo '<input type="hidden" name="name" value="'.$name.'">';
        echo '<input type="hidden" name="editYear" value="'.$editYear.'">';
        echo '<input type="text" name="editedData" value="'.$existingData['data'].'" class="form-control" placeholder="Enter edited data">';
        echo '<button type="submit" name="submitEdit" class="btn btn-primary">Submit Edit</button>';
        echo '</form>';
    }
}

// Check if the form for editing data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitEdit'])) {
    try {
        $editedData = isset($_POST['editedData']) ? trim($_POST['editedData']) : '';
        $editYear = isset($_POST['editYear']) ? $_POST['editYear'] : date('Y');

        // Update the existing data
        $updateStmt = $pdo->prepare("UPDATE line_graph SET data = :editedData WHERE name = :name AND year(data) = :year");
        $updateStmt->bindParam(':name', $name, PDO::PARAM_STR);
        $updateStmt->bindParam(':year', $editYear, PDO::PARAM_INT);
        $updateStmt->bindParam(':editedData', $editedData, PDO::PARAM_STR);
        $updateStmt->execute();

        echo "Data for year $editYear updated successfully<br>";
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
    <title>Insert Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body class="bg-dark">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center mb-4">Insert Data</h1>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Year</th>
                        <th>Data</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Display rows for each year
                    $startYear = 2000;
                    $endYear = 2023;

                    for ($year = $startYear; $year < $endYear; $year++) {
                        echo '<tr>';
                        echo '<td>' . $year . '</td>';
                        echo '<td><input type="text" name="data[' . $year . ']" class="form-control"></td>';
                        echo '<td><button type="submit" name="submitLine" class="btn btn-primary">Submit</button></td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
                <input type="hidden" name="name" value="CountyName"> 
          </form>
        </div>
    </div>
</div>

</body>
</html>
