<?php
class User {

    private $pdo;

    public function __construct($pdo) {

        $this->pdo = $pdo;

    }

    public function addUser(string $email, string $password): bool {

        $validator = new UserValidator();

        if ($validator->validateEmail($email) && $validator->validatePassword($password)) {

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['email' => $email, 'password' => $hashedPassword]);

        }

        return false;

    }

    public function editUser(int $id, string $email, string $password): bool {
        
        $validator = new UserValidator();

        if ($validator->validateEmail($email) && $validator->validatePassword($password)) {

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET email = :email, password = :password WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['email' => $email, 'password' => $hashedPassword, 'id' => $id]);

        }

        return false;

    }

    public function deleteUser(int $id): bool {

        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);

    }

    public function getUsers(): array {

        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getUser(int $id): array {

        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

}