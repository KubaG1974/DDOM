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
/* Poniżej metoda validatePassword w wersji "kompaktowej", jednak ze względu na czytelność kodu dla mniej zorientowanych
   zostawiłem wersję, jak wyżej. Łatwiej również debugować tak napisany kod.
 
   public function validatePassword(string $password): bool {
      return (bool) preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
    }*/

