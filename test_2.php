<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Validation Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input:focus {
            border-color: #007BFF;
            outline: none;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>User Validation</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>" required>
        </div>
        <button type="submit" class="btn">Validate</button>
    </form>

    <?php
    require 'UserValidator.php';

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
</div>

</body>
</html>
