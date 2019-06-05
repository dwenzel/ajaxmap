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

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Ajax Map',
	'description' => 'Versatile map extension. Map data are requested dynamically via ajax.',
	'category' => 'plugin',
	'author' => 'Dirk Wenzel',
	'author_email' => 'wenzel@cps-it.de',
	'author_company' => 'Agentur Webfox Berlin, CPS-IT Berlin',
	'state' => 'stable',
	'uploadfolder' => 1,
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '1.0.2',
	'constraints' =>
	array (
		'depends' =>
		array (
			'typo3' => '9.5.0-0.0.0',
			'tt_address' => '2.3.4-0.0.0',
			'geo_location_service' => '0.2.0-0.0.0',
		),
		'conflicts' =>
		array (
		),
		'suggests' =>
		array (
		),
	)
);

