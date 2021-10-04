<?php 

/**
 * Provides a basic encryption/decryption functionality
 */

 class Encryption 
 {
    public static function hashPassword(string $password) :string
    {
        return password_hash($password, config('app', 'password_hashing_algorithm')??'PASSWORD_DEFAULT');
    }   

    public static function checkPassword(string $password, string $password_hash) :bool 
    {
        return self::hashPassword($password) == $password_hash;
    }
 } 