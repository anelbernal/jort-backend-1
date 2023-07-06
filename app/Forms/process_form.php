<!DOCTYPE html>
<html>
<head>
  <title>PHP Form with Checkboxes</title>
</head>
<body>
  <?php
  // Check if the form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the selected options for question 1
    $question1Options = isset($_POST['question1']) ? $_POST['question1'] : [];
    foreach ($question1Options as $option) {
      echo "Question 1: " . $option . "<br>";
    }

    // Retrieve the selected options for question 2
    $question2Options = isset($_POST['question2']) ? $_POST['question2'] : [];
    foreach ($question2Options as $option) {
      echo "Question 2: " . $option . "<br>";
    }

    // Process other form data or perform additional actions as needed
  }
  ?>
  
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h3>Questions:</h3>

    <p>1. Do you like PHP?</p>
    <label><input type="checkbox" name="question1[]" value="Yes"> Yes</label>
    <label><input type="checkbox" name="question1[]" value="No"> No</label>

    <p>2. Have you used HTML before?</p>
    <label><input type="checkbox" name="question2[]" value="Yes"> Yes</label>
    <label><input type="checkbox" name="question2[]" value="No"> No</label>

    <!-- Add more questions and checkboxes as needed -->

    <br>
    <input type="submit" value="Submit">
  </form>
</body>
</html>
