<?php
// Include the connection file
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted for record deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteRecord'])) {

    // Retrieve form data
    try {
        $idToDelete = isset($_POST['idToDelete']) ? trim($_POST['idToDelete']) : '';

        // Check if the ID is not empty
        if (empty($idToDelete)) {
            echo "Error: ID is required for record deletion";
        } else {
            // Prepare the SQL statement for record deletion
            $deleteStmt = $pdo->prepare("DELETE FROM line_graph WHERE id = :idToDelete");
            $deleteStmt->bindParam(':idToDelete', $idToDelete, PDO::PARAM_INT);

            // Execute the deletion statement
            $deleteStmt->execute();

            // Check if any rows were affected
            $rowCount = $deleteStmt->rowCount();
            if ($rowCount > 0) {
                echo "Record with ID $idToDelete deleted successfully!";
            } else {
                echo "No record found with ID $idToDelete";
            }
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
    <title>Delete Record from line_graph</title>
</head>

<body>
    <!--<h2>Delete Record from line_graph table</h2> -->

    <form action="" method="post">
        <label for="idToDelete">ID to Delete:</label>
        <input type="text" id="idToDelete" name="idToDelete" required>

        <input type="submit" name="deleteRecord" value="Delete Record">
    </form>
</body>
</html>
