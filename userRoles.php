<?php
session_start();
require_once('config.php');

$errors = [];
$success = '';

// Check if the form for updating user roles is submitted
if (isset($_POST['updateRolesSubmit'])) {
    if (!empty($_POST['user_id']) && !empty($_POST['new_access_level'])) {
        $user_id = $_POST['user_id'];
        $new_access_level = $_POST['new_access_level'];

        // Update user access level in the database
        $sqlUpdate = "UPDATE members SET access_level = :new_access_level WHERE id = :user_id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':new_access_level', $new_access_level, PDO::PARAM_STR);
        $stmtUpdate->execute();

        $success = 'User role has been updated successfully';
    } else {
        $errors[] = 'Please select a user and specify a new access level';
    }
}

// Fetch users for display
$sqlSelectUsers = "SELECT id, email, access_level FROM members";
$stmtSelectUsers = $pdo->prepare($sqlSelectUsers);
$stmtSelectUsers->execute();
$users = $stmtSelectUsers->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Roles</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body class="bg-dark">

<div class="container h-100">
    <div class="row h-100 mt-5 justify-content-center align-items-center">
        <div class="col-md-8 mt-3 pt-2 pb-5 align-self-center border bg-light">
            <h1 class="mx-auto w-50">Edit User Roles</h1>
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
                <table class="table">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Access Level</th>
                        <th>New Access Level</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['access_level']; ?></td>
                            <td>
                                <select name="new_access_level">
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                    <option value="staff">Staff</option>

                                    
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="updateRolesSubmit" class="btn btn-primary">Update Role</button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </form>
            <p class="pt-2">Back to <a href="adminPage.php">Dashboard</a></p>
        </div>
    </div>
</div>

</body>
</html>
