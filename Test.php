<?php
require 'UserValidator.php';

$validator = new UserValidator();

$email = "test@testowy.pl";
$password = "Siln@Haslo1!";

echo $validator->validateEmail($email) ? "Dziękuję, adres e-mail jest poprawny.\n" : "Przykro mi, adres e-mail jest błędny.\n";
echo $validator->validatePassword($password) ? "Hasło poprawne.\n" : "Błędne hasło.\n";
