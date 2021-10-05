<?php

/*This file contains configuration options for the database connection/s
here you can set the database names, the server ip and usernames and passwords  */

use Framework\Classes\PDODatabaseAccess;

return [
    'connection_used'=>'connection1',
    
    'database_access_class'=>PDODatabaseAccess::class,

    'connection1'=>[
        'driver'=>'mysql',
        'db_host'=>'localhost',
        'db_port'=>3306,
        'db_name'=>'testdb',
        'db_user'=>'test',
        'db_password'=>'password',
        'db_charset'=>'utf8mb4'
    ]
];