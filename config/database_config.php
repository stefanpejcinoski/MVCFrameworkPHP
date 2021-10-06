<?php

/*This file contains configuration options for the database connection/s
here you can set the database names, the server ip and usernames and passwords  */

use Framework\Classes\PDODatabaseAccess;

return [
    /* The name of the connection used */
    'connection_used'=>'connection1',
    
    /* The database connection class used, it can be replaced with any class that implements the Framework/Interfaces/DatabaseAccess */
    'database_access_class'=>PDODatabaseAccess::class,

    /* Here you can define database connections, for now only the mysql driver is supported, for now the application models can only access one database connection */
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