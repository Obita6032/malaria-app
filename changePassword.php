<?php
session_start();
require_once('config.php');

$errors = [];
$success = '';

// Check if the form for changing password is submitted
if (isset($_POST['submit'])) {
    if (
        isset($_POST['email'], $_POST['current_password'], $_POST['new_password'], $_POST['confirm_password'])
        && !empty($_POST['email']) && !empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])
    ) {
        $email = trim($_POST['email']);
        $currentPassword = trim($_POST['current_password']);
        $newPassword = trim($_POST['new_password']);
        $confirmPassword = trim($_POST['confirm_password']);

        // Validate the current password against the stored hash
        $checkPasswordSql = 'SELECT password FROM members WHERE email = :email';
        $checkPasswordStmt = $pdo->prepare($checkPasswordSql);
        $checkPasswordStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $checkPasswordStmt->execute();

        if ($checkPasswordStmt->rowCount() === 1) {
            $storedPassword = $checkPasswordStmt->fetchColumn();
            if (!password_verify($currentPassword, $storedPassword)) {
                $errors[] = 'Current password is incorrect';
            }
        } else {
            $errors[] = 'Email does not exist in the database';
        }

        // Validate that the new password is not equal to the current password
        if (password_verify($newPassword, $storedPassword)) {
            $errors[] = 'New password should not be equal to the current password';
        }

        // Additional logic for validating the new password and confirmation
        // ...

        if (empty($errors)) {
            // Update the password in the database
            // ...
            $success = 'Password changed successfully!';
        }
    } else {
        // Validation for other fields if needed
        $errors[] = 'All fields are required';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="script.js"></script>
</head>
<body class="bg-dark">

<div class="container h-100">
    <div class="row h-100 mt-5 justify-content-center align-items-center">
        <div class="col-md-5 mt-3 pt-2 pb-5 align-self-center border bg-light">
            <h1 class="mx-auto w-50">Change Password</h1>
            <?php
            if (isset($errors) && count($errors) > 0) {
                foreach ($errors as $error_msg) {
                    echo '<div class="alert alert-danger">' . $error_msg . '</div>';
                }
            }

            if (!empty($success)) {
                echo '<div class="alert alert-success">' . $success . '</div>';
            }
            ?>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" placeholder="Enter Email" class="form-control"
                           value="<?php echo ($email ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" name="current_password" placeholder="Enter Current Password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" placeholder="Enter New Password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" placeholder="Confirm New Password" class="form-control">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Change Password</button>
            </form>
            <p class="pt-2">Back to <a href="adminPage.php">Dashboard</a></p>
        </div>
    </div>
</div>

</body>
</html>
