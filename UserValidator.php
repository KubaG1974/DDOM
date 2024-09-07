<?php
class UserValidator {
    
public function validateEmail(string $email): bool {
    
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);

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

