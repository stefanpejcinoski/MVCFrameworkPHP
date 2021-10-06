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
     
     /**
      * Method getInstance 
      *
      * Returns an instance of the class, allows chaining instantiation and method calls in one line of code
      *
      * @return Encryption
      */
     public static function getInstance() :Encryption
     {
        return new Encryption;
     }
         
    /**
     * Method hashPassword 
     * 
     * Creates a password hash from the provided password string using the hashing algorithm defined in the app config
     *
     * @param string $password The password string
     *
     * @return string The password hash
     */    
    public static function hashPassword(string $password) :string
    {
        return password_hash($password, config('app', 'password_hashing_algorithm'));
    }   
    
    /**
     * Method checkPassword
     *
     * Checks  the provided password string against the provided password hash.
     * Returns true if they match otherwise returns false
     * 
     * @param string $password The password string
     * @param string $password_hash The password hash
     *
     * @return bool
     */
    public static function checkPassword(string $password, string $password_hash) :bool 
    {
        return password_verify($password, $password_hash);
    }
    
    /**
     * Method encryptString
     *
     * Encrypts the provided string using the encryption algorithm defined in the app config
     * 
     * @param string $data The data string
     *
     * @return string The encrypted string
     */
    public function encryptString(string $data): string 
    {
        return openssl_encrypt($data, $this->algorithm, $this->privateKey);
    }
    
    /**
     * Method decryptString
     * 
     * Decrypts the provided string. Will work only on data encrypted using the encryption algorithm defined in the app config
     *
     * @param string $data The encrypted string
     *
     * @return string The decrypted data
     */
    public function decryptString(string $data) :string 
    {
        return openssl_decrypt($data, $this->algorithm, $this->privateKey);
    }
 } 