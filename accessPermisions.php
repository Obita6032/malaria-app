<?php
session_start();
require_once('config.php');

$errors = [];
$success = '';

// Check if the form for updating access level is submitted
if (isset($_POST['update_access'])) {
    if (isset($_POST['user_id'], $_POST['new_access_level']) && !empty($_POST['user_id']) && !empty($_POST['new_access_level'])) {
        $user_id = $_POST['user_id'];
        $new_access_level = $_POST['new_access_level'];

        // Update the access level in the database
        $sql = "UPDATE members SET access_level = :new_access_level WHERE id = :user_id";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['new_access_level' => $new_access_level, 'user_id' => $user_id]);
            $success = 'Access level updated successfully';
        } catch (PDOException $e) {
            $errors[] = $e->getMessage();
        }
    } else {
        $errors[] = 'Invalid data for updating access level';
    }
}

// Retrieve all users
$sql = 'SELECT id, first_name, last_name, access_level FROM members';
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body class="bg-dark">

<div class="container h-100">
    <div class="row h-100 mt-5 justify-content-center align-items-center">
        <div class="col-md-8 mt-3 pt-2 pb-5 align-self-center border bg-light">
            <h1 class="mx-auto w-50">User Acess Level Management</h1>
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
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Access Level</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['first_name']; ?></td>
                        <td><?php echo $user['last_name']; ?></td>
                        <td><?php echo $user['access_level']; ?></td>
                        <td>
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <select name="new_access_level" class="form-control">
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                    <option value="user">staff</option>
                                </select>
                                <button type="submit" name="update_access" class="btn btn-primary mt-2">Update Access</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p class="pt-2">Back to <a href="adminPage.php">Dashboard</a></p>
        </div>
    </div>
</div>

</body>
</html>
