<?php

return [
    'modules' => [
        'DNContact',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            '../config/autoload/{,*.}{global,local,testing}.php',
        ],
        'module_paths' => [
            '../../module',
        ],
    ],
];
