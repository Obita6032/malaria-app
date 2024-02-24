<?php
require_once('config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the survey data
    $satisfaction = isset($_POST['satisfaction']) ? $_POST['satisfaction'] : '';
    $comments = isset($_POST['comments']) ? $_POST['comments'] : '';

    // Store the data in the database
    $sql = "INSERT INTO survey_responses (satisfaction, comments) VALUES (:satisfaction, :comments)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute(['satisfaction' => $satisfaction, 'comments' => $comments]);

    if ($result) {
        // Redirect to a thank you page or display a success message
        header("Location: thank_you.php");
        exit();
    } else {
        // Display an error message if the insertion fails
        $error_message = "Error: Unable to store survey response.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body class="bg-dark">

<div class="container h-100">
    <div class="row h-100 mt-5 justify-content-center align-items-center">
        <div class="col-md-8 mt-3 pt-2 pb-5 align-self-center border bg-light">
            <h1 class="mx-auto w-50">Satisfactory Survey Form</h1>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form action="surveyForm.php" method="post">
                <p>How satisfied are you with our information?</p>
                <label>
            <input type="radio" name="satisfaction" value="very_satisfied"> Very Satisfied
        </label>
        <label>
            <input type="radio" name="satisfaction" value="satisfied"> Satisfied
        </label>
        <label>
            <input type="radio" name="satisfaction" value="neutral"> Neutral
        </label>
        <label>
            <input type="radio" name="satisfaction" value="dissatisfied"> Dissatisfied
        </label>
        <label>
            <input type="radio" name="satisfaction" value="very_dissatisfied"> Very Dissatisfied
        </label>

                <p>Additional Comments:</p>
                <textarea name="comments" rows="4" cols="50"></textarea>
                <br>
                <button type="submit">Submit</button>
            </form>

            <p class="pt-2">Back to <a href="adminPage.php">Dashboard</a></p>
        </div>
    </div>
</div>

</body>
</html>
