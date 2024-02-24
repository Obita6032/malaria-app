<?php 
//session_start();
//require_once('config.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data into the malaria2023 table  </title>
</head>
<body>
    <h2>Insert Data into the malaria2023 table</h2>
    
    <form action="bar_insert.php" method="post">
        <label for="month">Month:</label>
        <select name="month" id="month">
            <option value="Jan">Jan</option>
            <option value="Feb">Feb</option>
            <option value="Mar">Mar</option>
            <option value="Apr">Apr</option>
            <option value="May">May</option>
            <option value="Jun">Jun</option>
            <option value="Jul">Jul</option>
            <option value="Aug">Aug</option>
            <option value="Sep">Sep</option>
            <option value="Oct">Oct</option>
            <option value="Nov">Nov</option>
            <option value="Dec">Dec</option>
        </select>
        <input type="text" id="month" name="month" required>

        <label for="cases">cases:</label>
        <input type="number" id="cases" name="cases" required>

        <input type="submit" value="Insert">
    </form>
</body>
</html>
