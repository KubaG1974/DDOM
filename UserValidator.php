<?php
class userValidator {
    
    public function validateEmail(string $email): bool {
        
        $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        return (bool)preg_match($pattern, $email);  

    }

    public function validatePassword(string $password): bool {
        
        return strlen($password) >= 8 &&
           preg_match('/[A-Z]/', $password) &&
           preg_match('/[a-z]/', $password) &&
           preg_match('/\d/', $password) &&
           preg_match('/[\W_]/', $password);
        
    }

}
