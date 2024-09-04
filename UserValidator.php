<?php
class userValidator {
    
    public function validateEmail(string $email): bool {
        
        $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        return (bool)preg_match($pattern, $email);  

    }

    public function validatePassword(string $password): bool {
        
        if (strlen($password < 8)) {
            return false;
        }

       if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        if (!preg_match('/\d/', $password)) {
            return false;
        }

        if (!preg_match('/[\W_]/', $password)) {
            return false;
        }

        return true;        
        
    }

}
