<?php

return [
    'dn-contact' => [
        'mail_transport' => [
            'type' => 'sendmail',
        ],
        'success_message' => "Votre message a été correctement envoyé !",
        'redirect_route' => "home",
        'admin_mail' => "admin@test.com",
        'admin_name' => "Administrateur TEST",
        'use_gmap' => true,
        'address' => '<strong>Entreprise</strong><br/>78, rue des papillons<br/>17 000 La Rochelle<br/>',
        'gmap' => [
            'info' => '<div id="map-adress" class="text-center"><strong>Entreprise</strong><br/></div>',
            'options' => [
                'zoom' => "14",
                'scrollwheel' => false
            ],
            'center' => "46.1418, -1.1675",
        ],
    ],
];
