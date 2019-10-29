<?php

use Phalcon\Config;



return new Config(
    [
        'database'    => [
            'name'     => 'db/phalcon.SQLite',
            'dbname'     => 'db/phalcon.SQLite',
            'adapter'  => 'sqlite'
        ],
        'application' => [
            'modelsDir' =>  'app/models/',
            'migrationsDir' =>  'app/migrations/',
            'controllersDir' => 'app/controllers/',
            'baseUri'   => '/',
        ],
        'models'      => [
            'metadata' => [
                'adapter' => 'Memory'
            ]
        ]
    ]
);
