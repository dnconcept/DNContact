<?php

return [
    'modules' => [
        'DNContact',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            __DIR__  . '/autoload/{,*.}{global,local,testing}.php',
        ],
        'module_paths' => [
            './module',
            './library',
            './vendor',
        ],
    ],
];
