<?php
require 'Database.php';
require 'User.php';
require 'UserValidator.php';

$database = new Database();
$pdo = $database->getConnection();

$userObj = new User($pdo);
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $validator = new UserValidator();
    $emailValid = $validator->validateEmail($email);
    $passwordValid = $validator->validatePassword($password);

    if ($emailValid && $passwordValid) {

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {

            $userObj->updateUser($_POST['user_id'], $email, $hashedPassword);
            $message = '<div class="message success">User updated successfully!</div>';

        } else {

            $userObj->addUser($email, $hashedPassword);
            $message = '<div class="message success">User added successfully!</div>';

        }

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

if (isset($_GET['delete_id'])) {

    $userObj->deleteUser($_GET['delete_id']);
    header("Location: Test3.php");
    exit;

}

$editUser = null;

if (isset($_GET['id'])) {

    $editUser = $userObj->getUserById($_GET['id']);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
</head>
<body>

<div class="container">
    <h2>User Management</h2>

    <?php echo $message; ?>

    <form method="POST" action="Test3.php">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($editUser['email'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="" required>
        </div>
        <?php if ($editUser): ?>
            <input type="hidden" name="user_id" value="<?php echo $editUser['id']; ?>">
        <?php endif; ?>
        <button type="submit" class="btn"><?php echo $editUser ? 'Update User' : 'Add User'; ?></button>
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
        $users = $userObj->getUsers();

        foreach ($users as $user) {

            echo "<tr>";
            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
            echo "<td>";
            echo "<a href='Test3.php?id=" . $user['id'] . "'>Edit</a> | ";
            echo "<a href='Test3.php?delete_id=" . $user['id'] . "' onclick=\"return confirm('Are you sure you want to delete this user?')\">Delete</a>";
            echo "</td>";
            echo "</tr>";

        }
        ?>
    </table>
</div>

</body>
</html>
