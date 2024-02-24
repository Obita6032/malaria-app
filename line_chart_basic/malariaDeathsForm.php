<?php

include 'config.php';  

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $countyName = $_POST['county_name'];
    $deathsCount = $_POST['deaths_count'];
    $year = $_POST['year'];

    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO malaria_deaths (county_name, deaths_count, year) 
                          VALUES (:county_name, :deaths_count, :year)");

    // Bind parameters
    $stmt->bindParam(':county_name', $countyName, PDO::PARAM_STR);
    $stmt->bindParam(':deaths_count', $deathsCount, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();
    
    echo "Data successfully inserted.";
    exit();
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
            <h1 class="mx-auto w-25">Malaria Deaths </h1>
            
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="county_name">County Name:</label>
                    <input type="text" name="county_name" placeholder="" id="countyName" class="form-control"
                           value="<?php echo ($countyName ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="deaths_count">Deaths Count:</label>
                    <input type="number" name="deaths_count" placeholder="" id="deaths_count" class="form-control"
                           value="<?php echo ($deathsCount ?? ''); ?>">
                </div>
               
                <div class="form-group">
                    <label for="year">Year:</label>
                    <input type="number" name="year" id="yaer" placeholder="" class="form-control"
                           value="<?php echo ($year ?? ''); ?>">
                </div>
              
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <p class="pt-2">Back to <a href="">Dashboard</a></p>
        </div>
    </div>
</div>

</body>
</html>
