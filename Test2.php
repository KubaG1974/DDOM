<?php
require 'db.php';
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

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email, 'password' => $hashedPassword]);

        echo '<div class="message success">User added successfully!</div>';

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Validation Form</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
</head>
<body>

<div class="container">
    <h2>User Validation</h2>

    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
        </div>
        <button type="submit" class="btn">Add User</button>
    </form>
</div>

<div class="container">
    <h2>Users List</h2>
    <table>
        <tr>
            <th>Email</th>
            <th>Actions</th>
        </tr>

        <?php
        $sql = "SELECT * FROM users";
        $stmt = $pdo->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>";
            echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a> | ";
            echo "<a href='delete.php?id=" . $row['id'] . "'>Delete</a>";
            echo "</td>";
            echo "</tr>";

        }
        ?>
        
    </table>
</div>

</body>
</html>
