<?php
use Phalcon\Config;
$config = new Config(
    [
        'application' => [
            'viewsDir' => 'app/views/',
            'cacheDir' => 'app/cache/',
            'baseUri'  => '/app',
        ]
    ]
);