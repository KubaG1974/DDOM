<?php
require 'db.php';
require 'UserValidator.php';

$validator = new UserValidator();
$email = '';
$password = '';
$emailValid = true;
$passwordValid = true;

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch();

    if (!$user) {
        
        header("Location: test_2.php");
        exit;

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $emailValid = $validator->validateEmail($email);
        $passwordValid = empty($password) || $validator->validatePassword($password); 
        
        if ($emailValid && $passwordValid) {

            if (!empty($password)) {

                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $sql = "UPDATE users SET email = :email, password = :password WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['email' => $email, 'password' => $hashedPassword, 'id' => $id]);

            } else {

                $sql = "UPDATE users SET email = :email WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['email' => $email, 'id' => $id]);
                
            }
            
            header("Location: test_2.php");
            exit;

        } else {

            $message = '<div class="message error">';
            
            if (!$emailValid) {

                $message .= 'Invalid email format.<br>';
            }
            
            if (!$passwordValid) {

                $message .= 'Password does not meet the requirements.<br>';

            }

            $message .= '</div>';
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
</head>
<body>

<div class="container">
    <h2>Edit User</h2>

    <?php if (isset($message)) echo $message; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password (leave blank if not changing):</label>
            <input type="password" id="password" name="password">
        </div>
        <button type="submit" class="btn">Update User</button>
    </form>
</div>

</body>
</html>
