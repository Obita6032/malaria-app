<?php
session_start();
require_once('config.php');

$errors = [];
$success = '';

// Check if the form for creating a user is submitted
if (isset($_POST['submit'])) {
    if (
        isset($_POST['first_name'], $_POST['last_name'], $_POST['county'], $_POST['access_level'], $_POST['email'], $_POST['password'])
        && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['password'])
    ) {
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $county = trim($_POST['county']);
        $access_level = trim($_POST['access_level']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $options = array("cost" => 4);
        $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);
        $date = date('Y-m-d H:i:s');

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = 'SELECT * FROM members WHERE email = :email';
            $stmt = $pdo->prepare($sql);
            $p = ['email' => $email];
            $stmt->execute($p);

            if ($stmt->rowCount() == 0) {
                $sql = "INSERT INTO members (first_name, last_name, county, access_level, email, `password`, created_at, updated_at)
                        VALUES (:fname, :lname, :county, :access_level, :email, :pass, :created_at, :updated_at)";

                try {
                    $handle = $pdo->prepare($sql);
                    $params = [
                        ':fname' => $firstName,
                        ':lname' => $lastName,
                        ':county' => $county,
                        ':access_level' => $access_level,
                        ':email' => $email,
                        ':pass' => $hashPassword,
                        ':created_at' => $date,
                        ':updated_at' => $date
                    ];

                    $handle->execute($params);

                    $success = 'User has been created successfully';
                } catch (PDOException $e) {
                    $errors[] = $e->getMessage();
                }
            } else {
                $errors[] = 'Email address already registered';
            }
        } else {
            $errors[] = "Email address is not valid";
        }
    } else {
        // Validation for other fields if needed
        $errors[] = 'All fields are required';
    }
}
?>

<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="script.js"></script>
</head>
<body class="bg-dark">

<div class="container h-100">
    <div class="row h-100 mt-5 justify-content-center align-items-center">
        <div class="col-md-5 mt-3 pt-2 pb-5 align-self-center border bg-light">
            <h1 class="mx-auto w-25">Create User</h1>
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
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" placeholder="Enter First Name" class="form-control"
                           value="<?php echo ($firstName ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" placeholder="Enter Last Name" class="form-control"
                           value="<?php echo ($lastName ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="county">County:</label>
                    <input type="text" name="county" placeholder="Enter County" class="form-control"
                           value="<?php echo ($county ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="access_level">Access Level:</label>
                    <input type="text" name="access_level" placeholder="Enter Access Level" class="form-control"
                           value="<?php echo ($access_level ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" placeholder="Enter Email" class="form-control"
                           value="<?php echo ($email ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" placeholder="Enter Password" class="form-control">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Create User</button>
            </form>
            <p class="pt-2">Back to <a href="dashboard.php">Dashboard</a></p>
        </div>
    </div>
</div>

</body>
</html>
