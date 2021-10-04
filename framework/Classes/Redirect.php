<?php
use Framework\Classes\Request;
/**
 * Contains  basic functionality for returning redirects 
 */

 namespace Framework\Classes;

 class Redirect 
 {
    public static function redirectUnauthorized(Request $request)
    {
     
        $redirectUnauthorizedTo = Config::getConfig('app')->getKey('redirect_unauthorized');
        $routeForRedirect = Router::getRouter()->getRouteByName($redirectUnauthorizedTo);
        header('Location', $request->getHost().'/'.$routeForRedirect);
        http_response_code(401);
        die();
    }

 }