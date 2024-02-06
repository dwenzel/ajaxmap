<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "ajaxmap".
 *
 * Auto generated 12-09-2015 09:28
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'Ajax Map',
    'description' => 'Versatile map extension. Map data are requested dynamically via ajax.',
    'category' => 'plugin',
    'author' => 'Dirk Wenzel',
    'author_email' => 'wenzel@cps-it.de',
    'author_company' => 'Agentur Webfox Berlin, CPS-IT Berlin',
    'state' => 'stable',
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
            'tt_address' => '8.0.0-8.0.99',
            'geo_location_service' => '0.2.0-0.3.99',
        ],
    ],
];
