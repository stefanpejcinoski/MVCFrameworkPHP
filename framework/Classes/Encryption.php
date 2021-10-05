<?php 
namespace Framework\Classes;

/**
 * Provides a basic encryption/decryption functionality
 */

 class Encryption 
 {
    public static function hashPassword(string $password) :string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }   

    public static function checkPassword(string $password, string $password_hash) :bool 
    {
        return self::hashPassword($password) == $password_hash;
    }
 } 