<?php

/**
 * Contains  basic functionality for returning redirects 
 */
namespace Framework\Classes;
 

 class Redirect 
 {
         
    /**
     * Method redirectUnauthorized
     * 
     * Redirect unauthorized users to the page set in the app config
     *
     * @return void
     */
    public static function redirectUnauthorized()
    {
        Session::append('errors', "You're not authorized to see this page");
        $redirectUnauthorizedTo = config('app', 'redirect_unauthorized');
        $routeForRedirect = route($redirectUnauthorizedTo);
        header('Location: '.$routeForRedirect, true, 401);
        exit();
    }
    
    /**
     * Method redirectToRouteWithCode
     * 
     * Redirect to the provided route with the provided status code
     *
     * @param string $route The route to redirect to
     * @param int $code The status code
     *
     * @return void
     */
    public static function redirectToRouteWithCode(string $route, int $code){
        http_response_code($code);
        header('Location: '.$route);
        exit();
    }
    
    /**
     * Method redirectWithErrors
     * 
     * Redirect back to the previous route with a status code
     *
     * @param int $code The status code
     *
     * @return void
     */
    public static function redirectWithErrors(int $code)
    {
        $previousRoute = Session::getKey('current_route');
        Session::clearKey('current_route');
        http_response_code($code);
        header('Location: '.$previousRoute);
        exit();
    }
    
    /**
     * Method redirectBack
     * 
     * Redirect the user back to the previous route
     *
     * @return void
     */
    public static function redirectBack()
    {
        $previousRoute = Session::getKey('current_route');
        Session::clearKey('current_route');
        header('Location: '.$previousRoute);
        exit();
    }
    
    /**
     * Method redirectHome
     * 
     * Redirect the user back to the home page
     *
     * @return void
     */
    public static function redirectHome(?int $code = null)
    {
        $homeRoute = config('app', 'home_route');
        $routeForRedirect = route($homeRoute);
        http_response_code($code??200);
        header("Location: ".$routeForRedirect);
        exit();
    }
    
    /**
     * Method refresh
     * 
     * Refresh the current page
     *
     * @return void
     */
    public static function refresh()
    {
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    }
 }