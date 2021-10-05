<?php 
 namespace Framework\Classes;

/**
 * Provides functionality for setting and reading encrypted cookies
 */

 use Framework\Classes\Request;
 use Framework\Classes\Encryption;

 class Cookies 
 {
     
    /**
     * Read an encrypted cookie from the incoming request. Returns the cookie on success or false on failure
     *
     * @param Request $request The request object
     * @param string $cookie The name of the cookie 
     * 
     * Returns the cookie on success or false on failure
     */
    public static function readCookieFromRequest(Request $request, string $cookie)
    {
        if($cookieString = $request->getCookie($cookie))
            return Encryption::getInstance()->decryptString($cookieString);
        else return false;
    }

        
    /**
     * Set an encrypted cookie
     *
     * @param string $name cookie name
     * @param string $data cookie data
     * @param int $expires UNIX timestamp of when the cookie expires, or 0 for never.
     * @param string $path Path on the server where the cookie is available.
     * @param string $domain The (sub)domain where the cookie is available.
     * @param bool $secure Indicates whether the cookie should only be transmitted on a HTTPS connection.
     * @param bool $httponly When true the cookie will only be accessible through the HTTP protocol.
     *
     * @return void
     */
    public static function setCookie(string $name, string $data, int $expires = 0, string $path = '' , string $domain = '', bool $secure = false, bool $httponly = false)
    {
        return setcookie($name, Encryption::getInstance()->encryptString($data), $expires, $path, $domain, $secure, $httponly);
    }
 }