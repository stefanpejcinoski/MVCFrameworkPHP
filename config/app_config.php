<?php
/*This file contains configuration options for the application itself
here you can set debug messages on or off and set the app name */
return [


    /* This property defines the template rendering engine to be used, by default it's Smarty PHP but it can be redefined
    note that you also need to make an interface class for the engine you're planning to use 
    and have it implement the Framework/Interfaces/TemplateRendering interface. */
    'template_engine'=>[SmartyTemplateRendering::class],
    /* Set the app name which can later be retrieved anywhere in the application */ 
    'app_name'=>"Framework test app",

    /* Set the tamplate directory for Smarty templates */
    'template_directory'=>'resources/templates',

    /* Set the root directory for the application */
    'root_directory'=>$_SERVER['DOCUMENT_ROOT'],

    /* Set the directory for stylesheets */
    'stylesheets_directory'=>'resources/css',

    /* Set the directory for javascript scripts */
    'scripts_directory'=>'resources/js',

    /* Set the directory for compiled Smarty templates */
    'compiled_templates_directory'=>'storage/views',

    /* Set maintenance mode for your application */
    'maintenance'=>'Off'
];