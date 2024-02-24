<?php
session_start();
require_once('config.php');

$errors = [];
$user = null;


if (isset($_POST['submit'])) {
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

// Check if the form for updating user is submitted
if (isset($_POST['updateSubmit'])) {
    $user_id = $_POST['user_id'];
    $newFirstName = $_POST['new_first_name'];
    $newLastName = $_POST['new_last_name'];
    $newCounty = $_POST['new_county'];
    $newAccessLevel = $_POST['new_access_level'];
    $newEmail = $_POST['new_email'];

    // Update user details in the database
    $sqlUpdate = "UPDATE members SET first_name = :new_first_name, last_name = :new_last_name, county = :new_county, access_level = :new_access_level, email = :new_email WHERE id = :user_id";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':new_first_name', $newFirstName);
    $stmtUpdate->bindParam(':new_last_name', $newLastName);
    $stmtUpdate->bindParam(':new_county', $newCounty);
    $stmtUpdate->bindParam(':new_access_level', $newAccessLevel);
    $stmtUpdate->bindParam(':new_email', $newEmail);
    $stmtUpdate->bindParam(':user_id', $user_id);
    $stmtUpdate->execute();

    if($sqlUpdate){
        echo" User Updated";
    }else{
        echo "Failed to upadte";
    }

    // Redirect to the view page after updating
    header("Location: edit_user.php?user_id=$user_id");
    exit();
}

// Check if the form for viewing user is submitted
if (isset($_POST['submit'])) {
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="script.js"></script>
</head>
<body class="bg-dark">

<body class="bg-dark">

<div class="container h-100">
    <div class="row h-100 mt-5 justify-content-center align-items-center">
        <div class="col-md-5 mt-3 pt-2 pb-5 align-self-center border bg-light">
            <h1 class="mx-auto w-50">View User</h1>
            <?php
            if (isset($errors) && count($errors) > 0) {
                foreach ($errors as $error_msg) {
                    echo '<div class="alert alert-danger">' . $error_msg . '</div>';
                }
            }
            ?>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="user_id">User ID:</label>
                    <input type="text" name="user_id" placeholder="Enter User ID" class="form-control" value="<?php echo ($_POST['user_id'] ?? ''); ?>">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">View User</button>
            </form>

            <?php
            if ($user) {
                // Display user details if user is found
                echo '<div class="mt-3">';
                echo '<h5>User Details:</h5>';
                echo '<p><strong>User ID:</strong> ' . $user['id'] . '</p>';
                echo '<p><strong>First Name:</strong> ' . $user['first_name'] . '</p>';
                echo '<p><strong>Last Name:</strong> ' . $user['last_name'] . '</p>';
                echo '<p><strong>County:</strong> ' . $user['county'] . '</p>';
                echo '<p><strong>Access Level:</strong> ' . $user['access_level'] . '</p>';

                echo '<p><strong>Email:</strong> ' . $user['email'] . '</p>';
                // Display other user details as needed
                echo '</div>';
            }
            ?>
            <p class="pt-2">Back to <a href="adminPage.php">Dashboard</a></p>
        </div>
    </div>
</div>

<div class="container h-100">
    <div class="row h-100 mt-5 justify-content-center align-items-center">
        <div class="col-md-5 mt-3 pt-2 pb-5 align-self-center border bg-light">
            <h1 class="mx-auto w-50">Edit User</h1>
            <?php
            if (isset($errors) && count($errors) > 0) {
                foreach ($errors as $error_msg) {
                    echo '<div class="alert alert-danger">' . $error_msg . '</div>';
                }
            }
            ?>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="user_id">User ID:</label>
                    <input type="text" name="user_id" readonly class="form-control" value="<?php echo ($user['id'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="new_first_name"> First Name:</label>
                    <input type="text" name="new_first_name" class="form-control" value="<?php echo ($user['first_name'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="new_last_name">Last Name:</label>
                    <input type="text" name="new_last_name" class="form-control" value="<?php echo ($user['last_name'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="new_county">County:</label>
                    <input type="text" name="new_county" class="form-control" value="<?php echo ($user['county'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="new_access_level"> Access Level:</label>
                    <input type="text" name="new_access_level" class="form-control" value="<?php echo ($user['access_level'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="new_email">Email:</label>
                    <input type="email" name="new_email" class="form-control" value="<?php echo ($user['email'] ?? ''); ?>">
                </div>
                <button type="submit" name="updateSubmit" class="btn btn-primary">Update User</button>
            </form>
            <p class="pt-2">Back to <a href="adminPage.php">Dashboard</a></p>
        </div>
    </div>
</div>

</body>
</html>
