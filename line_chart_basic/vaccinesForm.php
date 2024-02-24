<?php

include 'config.php'; 
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $countyName = $_POST['county_name'];
    $vaccinesReceived = $_POST['vaccines_received'];
    $vaccinesAdministered = $_POST['vaccines_administered'];
    $dateReceived = $_POST['date_received'];
    $dateAdministered = ($_POST['date_administered'] !== '') ? $_POST['date_administered'] : null;

    // Prepare the SQL statement
    $stmt = $pdo->prepare("INSERT INTO county_vaccine_data (county_name, vaccines_received, vaccines_administered, date_received, date_administered) 
                          VALUES (:county_name, :vaccines_received, :vaccines_administered, :date_received, :date_administered)");

    // Bind parameters
    $stmt->bindParam(':county_name', $countyName, PDO::PARAM_STR);
    $stmt->bindParam(':vaccines_received', $vaccinesReceived, PDO::PARAM_INT);
    $stmt->bindParam(':vaccines_administered', $vaccinesAdministered, PDO::PARAM_INT);
    $stmt->bindParam(':date_received', $dateReceived, PDO::PARAM_STR);
    $stmt->bindParam(':date_administered', $dateAdministered, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    echo "Data successfully inserted.";
    
  
   
    //header('Location: success.php');
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
            <h1 class="mx-auto w-25">Vaccines Data</h1>
            
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="countyName">County Name:</label>
                    <input type="text" name="county_name" placeholder="" id="countyName" class="form-control"
                           value="<?php echo ($countyName ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="vaccinesReceived">Vaccines Received:</label>
                    <input type="text" name="vaccines_received" placeholder="" id="vaccinesReceived" class="form-control"
                           value="<?php echo ($vaccinesReceived ?? ''); ?>">
                </div>
               
                <div class="form-group">
                    <label for="vaccinesAdministered">Vaccines Administered:</label>
                    <input type="number" name="vaccines_administered" id="vaccinesAdministered" placeholder="" class="form-control"
                           value="<?php echo ($vaccinesAdministered ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="dateReceived">Date Received:</label>
                    <input type="date" name="date_received" id="dateReceived" placeholder="" class="form-control"
                           value="<?php echo ($dateReceived ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="dateAdministered">Date Administered:</label>
                    <input type="date" name="date_administered" id="dateAdministered" placeholder="" class="form-control"
                           value="<?php echo ($dateAdministered ?? ''); ?>">
                </div>
           
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <p class="pt-2">Back to <a href="">Dashboard</a></p>
        </div>
    </div>
</div>

</body>
</html>
