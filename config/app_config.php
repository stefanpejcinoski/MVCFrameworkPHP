<?php
/*This file contains configuration options for the application itself
here you can set debug messages on or off and set the app name */
return [
    /* Set enable or disable debug messages */
    'debug'=>true,

    /* Set the app name which can later be retrieved anywhere in the application */ 
    'app_name'=>"Framework test app",
    'template_directory'=>'resources/templates',
    'root_directory'=>$_SERVER['DOCUMENT_ROOT'],
    'stylesheets_directory'=>'resources/css',
    'scripts_directory'=>'resources/js',
    'compiled_templates_directory'=>'storage/views'
];