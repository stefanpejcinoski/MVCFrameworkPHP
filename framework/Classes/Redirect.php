<?php
namespace Framework\Classes;
use Framework\Classes\Request;
/**
 * Contains  basic functionality for returning redirects 
 */

 

 class Redirect 
 {
    public static function redirectUnauthorized()
    {
        Session::append('errors', "You're not authorized to see this page");
        $redirectUnauthorizedTo = Config::getConfig('app')->getKey('redirect_unauthorized');
        $routeForRedirect = Router::getRouter()->getRouteByName($redirectUnauthorizedTo);
        http_response_code(401);
        header('Location: '.$routeForRedirect);
        exit();
    }
    public static function redirectWithValidationErrors()
    {
        $previousRoute = Session::getKey('current_route');
        http_response_code(422);
        header('Location: '.$previousRoute);
        exit();
    }
 }