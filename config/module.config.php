<?php

return [
    'dn-contact' => [
        'mail_transport' => [ //Zend\Mail\Transport\Factory
            'type' => 'smtp',   // 'file' | 'null' | 'sendmail' | 'smtp'  
            'options' => [
                'port' => 1025, //Port de maildev à lancer en console
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            'DNContact\Controller\Contact' => 'DNContact\Factory\ContactControllerFactory',
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        ],
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
    ],
    'translator' => [
        'locale' => 'fr_FR',
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'contact' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/contact',
                    'defaults' => [
                        'controller' => 'DNContact\Controller\Contact',
                        'action' => 'contact',
                    ],
                ],
            ]
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
