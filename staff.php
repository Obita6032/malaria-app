
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello Staff</h1>
    <?php 
    //retrieve name from the database
    $query = "SELECT first_name from members WHERE email= :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user=$stmt->fetch();
    //display name
    echo '<div class="user-name">'. $user['first_name'] . '</div>';
    ?>


</body>
</html>