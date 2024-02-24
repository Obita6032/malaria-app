<?php
session_start();
require_once('config.php');

$errors = [];
$user = null;

// Check if the form for deleting user is submitted
if (isset($_POST['deleteSubmit'])) {
    if (!empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        // Retrieve user information from the database based on user_id
        $sql = "SELECT * FROM members WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $errors[] = 'User not found';
        }
    } else {
        $errors[] = 'Please enter a user ID';
    }
}

// Check if the form for confirming deletion is submitted
if (isset($_POST['confirmDelete'])) {
    if (!empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        // Delete user from the database based on user_id
        $sqlDelete = "DELETE FROM members WHERE id = :user_id";
        $stmtDelete = $pdo->prepare($sqlDelete);
        $stmtDelete->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmtDelete->execute();

        // Redirect to the dashboard after deleting
        header("Location: adminPage.php");
        exit();
    } else {
        $errors[] = 'Invalid user ID for deletion';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="script.js"></script>
</head>
<body class="bg-dark">

<div class="container h-100">
    <div class="row h-100 mt-5 justify-content-center align-items-center">
        <div class="col-md-5 mt-3 pt-2 pb-5 align-self-center border bg-light">
            <h1 class="mx-auto w-50">Delete User</h1>
            <?php
            if (isset($errors) && count($errors) > 0) {
                foreach ($errors as $error_msg) {
                    echo '<div class="alert alert-danger">' . $error_msg . '</div>';
                }
            }
            ?>
            
            <?php if ($user): ?>
                <div class="mt-3">
                    <h5>User Details:</h5>
                    <p><strong>User ID:</strong> <?php echo $user['id']; ?></p>
                    <p><strong>First Name:</strong> <?php echo $user['first_name']; ?></p>
                    <p><strong>Last Name:</strong> <?php echo $user['last_name']; ?></p>
                    <p><strong>County:</strong> <?php echo $user['county']; ?></p>
                    <p><strong>Access Level:</strong> <?php echo $user['access_level']; ?></p>
                    <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                   
                </div>
                
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <button type="submit" name="confirmDelete" class="btn btn-danger mt-3">Confirm Delete</button>
                </form>
            <?php endif; ?>

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group mt-3">
                    <label for="user_id">User ID:</label>
                    <input type="text" name="user_id" placeholder="Enter User ID" class="form-control" value="<?php echo ($_POST['user_id'] ?? ''); ?>">
                </div>
                <button type="submit" name="deleteSubmit" class="btn btn-primary">Check User</button>
            </form>

            <p class="pt-2">Back to <a href="adminPage.php">Dashboard</a></p>
        </div>
    </div>
</div>

</body>
</html>
