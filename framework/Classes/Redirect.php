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
        $redirectUnauthorizedTo = config('app', 'redirect_unauthorized');
        $routeForRedirect = route($redirectUnauthorizedTo);
        header('Location: '.$routeForRedirect, true, 401);
        exit();
    }
    public static function redirectWithErrors(int $code)
    {
        $previousRoute = Session::getKey('current_route');
        http_response_code($code);
        header('Location: '.$previousRoute);
        exit();
    }

    public static function redirectHome()
    {
        $homeRoute = config('app', 'home_route');
        $routeForRedirect = route($homeRoute);
        header("Location: ".$routeForRedirect);
        exit();
    }
 }