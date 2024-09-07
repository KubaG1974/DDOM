<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Validation Form</title>
    <link href="stylesheet.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>User Validation</h2>

    <?php
    
    require 'UserValidator.php';

    $email = '';
    $password = '';
    $emailValid = true;
    $passwordValid = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $validator = new UserValidator();
        $email = $_POST['email'];
        $password = $_POST['password'];

        $emailValid = $validator->validateEmail($email);
        $passwordValid = $validator->validatePassword($password);

        if ($emailValid && $passwordValid) {
            echo '<div class="message success">Both email and password are valid!</div>';
        } else {
            echo '<div class="message error">';
            if (!$emailValid) {
                echo 'Invalid email format.<br>';
            }
            if (!$passwordValid) {
                echo 'Password does not meet the requirements.<br>';
            }
            echo '</div>';
        }
    }
    ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
        </div>
        <button type="submit" class="btn">Validate</button>
    </form>
</div>

</body>
</html>
