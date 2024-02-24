<?php 
include 'db.php';

function login($email, $password) {
    global $conn;
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        return $user;
    } else {
        return false;
    }
}

function isAdmin($user) {
    return $user['role'] == 'admin';
}

function getAllUsers() {
    global $conn;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $users = array();

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    return $users;
}

function createUser($username, $password, $role) {
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashedPassword', '$role')";
    $conn->query($sql);
}

function updateUser($id, $username, $password, $role) {
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET username='$username', password='$hashedPassword', role='$role' WHERE id=$id";
    $conn->query($sql);
}

function deleteUser($id) {
    global $conn;
    $sql = "DELETE FROM users WHERE id=$id";
    $conn->query($sql);
}
?>


