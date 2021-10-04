<?php

/*This file contains configuration options for the database connection/s
here you can set the database names, the server ip and usernames and passwords  */

return [
    'connection_used'=>'connection1',
    
    'database_driver_class'=>PDODatabaseAccess::class,

    'connection1'=>[
        'driver'=>'mysql',
        'db_host'=>'localhost',
        'db_name'=>'database',
        'db_password'=>'pass'
    ]
];