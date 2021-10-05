<?php
/*This file contains configuration options for the application itself
here you can set debug messages on or off and set the app name */

use Framework\Classes\SessionAuthenticator;
use Framework\Classes\SmartyRenderer;

return [

    /* When setting paths don't add a leading or trailing backslash, example "parent/directory" instead of "/parent/directory/"

    /* This property defines the template rendering engine to be used, by default it's Smarty PHP but it can be redefined
    note that you also need to make an interface class for the engine you're planning to use 
    and have it implement the Framework/Interfaces/TemplateRendering interface. */
    'template_engine'=>SmartyRenderer::class,
    /* Set the app name which can later be retrieved anywhere in the application */ 
    'app_name'=>"Framework test app",

    /* Set the tamplate directory for Smarty templates */
    'template_directory'=>'resources/templates',

    /*The home route */
    'home_route'=>'home',

    /* Set the directory for stylesheets */
    'stylesheets_directory'=>'resources/css',

    /* Set the directory for javascript scripts */
    'scripts_directory'=>'resources/js',

    /* Set the directory for compiled Smarty templates */
    'compiled_templates_directory'=>'storage/views',

    /* Set maintenance mode for your application */
    'maintenance'=>'Off',

    /* Set csrf protection on or off (recommended on) */
    'csrf'=>'On',

    /* 404 Page not found template name */
    'page_not_found_template'=>'pagenotfound',

    /* Location where unauthorized users are redirected */
    'redirect_unauthorized'=>'home',

    /* Algorithm used for hashing passwords */
    'password_hashing_algorithm'=>'2y',

    /* Algorithm used for 2 way encryption */
    'encryption_algorithm'=>'aes256',

    /* 2 way encryption cypher */
    'private_key'=>'@NcRfUjXn2r5u8x/A%D*G-KaPdSgVkYp3s6v9y$B&E(H+MbQeThWmZq4t7w!z%C*',

    /* Class for authentication */
    'auth'=>SessionAuthenticator::class
];