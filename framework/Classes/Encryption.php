<?php 
namespace Framework\Classes;

/**
 * Provides a basic encryption/decryption functionality
 */

 class Encryption 
 {
     protected string $algorithm;
     protected string $privateKey;

     public function __construct()
     {
         $this->algorithm = config('app', 'encryption_algorithm');
         $this->privateKey = config('app', 'private_key');
     }

     public static function getInstance() :Encryption
     {
        return new Encryption;
     }
    public static function hashPassword(string $password) :string
    {
        return password_hash($password, config('app', 'password_hashing_algorithm'));
    }   

    public static function checkPassword(string $password, string $password_hash) :bool 
    {
        return password_verify($password, $password_hash);
    }

    public function encryptString(string $data): string 
    {
        return openssl_encrypt($data, $this->algorithm, $this->privateKey);
    }

    public function decryptString(string $data) :string 
    {
        return openssl_decrypt($data, $this->algorithm, $this->privateKey);
    }
 } 