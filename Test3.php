<?php
require 'Database.php';
require 'UserValidator.php';
require 'User.php';

$db = new Database();
$pdo = $db->getConnection();
$user = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($_POST['id'])) {

        $user->editUser((int)$_POST['id'], $email, $password);

    } else {

        $user->addUser($email, $password);

    }
    
}

$users = $user->getUsers();
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
        <h2>Add/Edit User</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <div>
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Submit</button>
        </form>
        
        <h2>Users List</h2>
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <a href="index.php?id=<?php echo $user['id']; ?>">Edit</a> | 
                            <a href="delete.php?id=<?php echo $user['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
