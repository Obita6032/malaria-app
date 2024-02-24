<?php 
//session_start();
require_once('config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data into line_graph </title>
</head>
      
<body>
    <h2>Insert Data into line_graph table</h2>
    
    <form action="line_insert.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="data">Data:</label>
        <input type="text" id="data" name="data" required>

        <input type="submit" name="submitLine" value="Insert">
    </form>
</body>
</html>