<?php

########################################################################
# Extension Manager/Repository config file for ext "ajaxmap".
#
# Auto generated 22-07-2012 00:12
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Ajax Map',
	'description' => 'Display a map and request map data dynamically via ajax.',
	'category' => 'plugin',
	'author' => 'Dirk Wenzel',
	'author_email' => 'wenzel@webfox01.de',
	'author_company' => 'Agentur Webfox Berlin',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
			'extbase' => '6.2',
			'fluid' => '6.2',
			'typo3' => '6.2.0-6.2.99',
			'pt_extbase' => '1.5.8-',
			'tt_address' => '2.3.4-'
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:117:{s:9:"ChangeLog";s:4:"63ea";s:21:"ExtensionBuilder.json";s:4:"f0c2";s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"13e5";s:14:"ext_tables.php";s:4:"fd4e";s:14:"ext_tables.sql";s:4:"661d";s:24:"ext_typoscript_setup.txt";s:4:"d41d";s:40:"Classes/Controller/AddressController.php";s:4:"ae5f";s:41:"Classes/Controller/CategoryController.php";s:4:"121d";s:40:"Classes/Controller/ContentController.php";s:4:"8a8e";s:45:"Classes/Controller/LocationTypeController.php";s:4:"c0cf";s:36:"Classes/Controller/MapController.php";s:4:"d14f";s:38:"Classes/Controller/PlaceController.php";s:4:"9da7";s:39:"Classes/Controller/RegionController.php";s:4:"2d6b";s:32:"Classes/Domain/Model/Address.php";s:4:"4d7b";s:33:"Classes/Domain/Model/Category.php";s:4:"8b20";s:32:"Classes/Domain/Model/Content.php";s:4:"3eea";s:37:"Classes/Domain/Model/LocationType.php";s:4:"b911";s:28:"Classes/Domain/Model/Map.php";s:4:"5fb9";s:30:"Classes/Domain/Model/Place.php";s:4:"8b9a";s:31:"Classes/Domain/Model/Region.php";s:4:"f5e0";s:48:"Classes/Domain/Repository/CategoryRepository.php";s:4:"12e0";s:47:"Classes/Domain/Repository/ContentRepository.php";s:4:"12e0";s:43:"Classes/Domain/Repository/MapRepository.php";s:4:"b946";s:45:"Classes/Domain/Repository/PlaceRepository.php";s:4:"93bc";s:46:"Classes/Domain/Repository/RegionRepository.php";s:4:"74fa";s:30:"Classes/Utility/Dispatcher.php";s:4:"b46c";s:23:"Classes/Utility/Div.php";s:4:"cf1b";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"9243";s:40:"Configuration/FlexForms/flexform_map.xml";s:4:"806b";s:29:"Configuration/TCA/Address.php";s:4:"c1d8";s:30:"Configuration/TCA/Category.php";s:4:"cbfd";s:29:"Configuration/TCA/Content.php";s:4:"c1d8";s:34:"Configuration/TCA/LocationType.php";s:4:"dff2";s:25:"Configuration/TCA/Map.php";s:4:"9e34";s:27:"Configuration/TCA/Place.php";s:4:"976a";s:28:"Configuration/TCA/Region.php";s:4:"f8a8";s:38:"Configuration/TypoScript/constants.txt";s:4:"9054";s:34:"Configuration/TypoScript/setup.txt";s:4:"5925";s:43:"Resources/Private/Language/de.locallang.xlf";s:4:"01f7";s:40:"Resources/Private/Language/locallang.xlf";s:4:"281d";s:40:"Resources/Private/Language/locallang.xml";s:4:"ef0c";s:55:"Resources/Private/Language/locallang_csh_tt_address.xlf";s:4:"eb1d";s:55:"Resources/Private/Language/locallang_csh_tt_content.xlf";s:4:"eb1d";s:77:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_category.xlf";s:4:"9b77";s:77:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_location.xlf";s:4:"71ae";s:81:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_locationtype.xlf";s:4:"7b37";s:72:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_map.xlf";s:4:"63ab";s:76:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_maptype.xlf";s:4:"e7f4";s:74:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_place.xlf";s:4:"ecb4";s:75:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_region.xlf";s:4:"5f2d";s:43:"Resources/Private/Language/locallang_db.xlf";s:4:"4cf7";s:38:"Resources/Private/Layouts/Default.html";s:4:"a61f";s:42:"Resources/Private/Partials/FormErrors.html";s:4:"3f8e";s:50:"Resources/Private/Partials/Address/Properties.html";s:4:"31f8";s:51:"Resources/Private/Partials/Category/FormFields.html";s:4:"0ecc";s:51:"Resources/Private/Partials/Category/Properties.html";s:4:"4623";s:50:"Resources/Private/Partials/Content/Properties.html";s:4:"31f8";s:51:"Resources/Private/Partials/Location/FormFields.html";s:4:"4bb6";s:51:"Resources/Private/Partials/Location/Properties.html";s:4:"4e38";s:46:"Resources/Private/Partials/Map/FormFields.html";s:4:"28af";s:46:"Resources/Private/Partials/Map/Properties.html";s:4:"6faa";s:48:"Resources/Private/Partials/Place/Properties.html";s:4:"0627";s:49:"Resources/Private/Partials/Region/FormFields.html";s:4:"3a79";s:43:"Resources/Private/Partials/Region/Item.html";s:4:"ef5e";s:49:"Resources/Private/Partials/Region/Properties.html";s:4:"1c6e";s:45:"Resources/Private/Templates/Address/List.html";s:4:"eb5a";s:45:"Resources/Private/Templates/Address/Show.html";s:4:"cd93";s:46:"Resources/Private/Templates/Category/Edit.html";s:4:"7ac3";s:46:"Resources/Private/Templates/Category/List.html";s:4:"76ab";s:45:"Resources/Private/Templates/Category/New.html";s:4:"8291";s:46:"Resources/Private/Templates/Category/Show.html";s:4:"2655";s:45:"Resources/Private/Templates/Content/List.html";s:4:"550b";s:45:"Resources/Private/Templates/Content/Show.html";s:4:"61c2";s:46:"Resources/Private/Templates/Location/Edit.html";s:4:"fe85";s:46:"Resources/Private/Templates/Location/List.html";s:4:"ad98";s:45:"Resources/Private/Templates/Location/New.html";s:4:"07f1";s:46:"Resources/Private/Templates/Location/Show.html";s:4:"1783";s:41:"Resources/Private/Templates/Map/Edit.html";s:4:"ccd4";s:41:"Resources/Private/Templates/Map/List.html";s:4:"bee8";s:40:"Resources/Private/Templates/Map/New.html";s:4:"c6f0";s:41:"Resources/Private/Templates/Map/Show.html";s:4:"7e9e";s:43:"Resources/Private/Templates/Place/List.html";s:4:"cc7a";s:43:"Resources/Private/Templates/Place/Show.html";s:4:"18d8";s:44:"Resources/Private/Templates/Region/Edit.html";s:4:"4579";s:44:"Resources/Private/Templates/Region/List.html";s:4:"786a";s:43:"Resources/Private/Templates/Region/New.html";s:4:"bdef";s:44:"Resources/Private/Templates/Region/Show.html";s:4:"e439";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:37:"Resources/Public/Icons/tt_address.gif";s:4:"1103";s:37:"Resources/Public/Icons/tt_content.gif";s:4:"1103";s:59:"Resources/Public/Icons/tx_ajaxmap_domain_model_category.gif";s:4:"905a";s:59:"Resources/Public/Icons/tx_ajaxmap_domain_model_location.gif";s:4:"905a";s:63:"Resources/Public/Icons/tx_ajaxmap_domain_model_locationtype.gif";s:4:"4e5b";s:54:"Resources/Public/Icons/tx_ajaxmap_domain_model_map.gif";s:4:"905a";s:56:"Resources/Public/Icons/tx_ajaxmap_domain_model_place.gif";s:4:"905a";s:57:"Resources/Public/Icons/tx_ajaxmap_domain_model_region.gif";s:4:"905a";s:42:"Resources/Public/JavaScript/ajaxmapMain.js";s:4:"ac1e";s:47:"Tests/Unit/Controller/AddressControllerTest.php";s:4:"45bf";s:48:"Tests/Unit/Controller/CategoryControllerTest.php";s:4:"7aaf";s:47:"Tests/Unit/Controller/ContentControllerTest.php";s:4:"8b2c";s:48:"Tests/Unit/Controller/LocationControllerTest.php";s:4:"3962";s:52:"Tests/Unit/Controller/LocationTypeControllerTest.php";s:4:"7ed6";s:43:"Tests/Unit/Controller/MapControllerTest.php";s:4:"2371";s:47:"Tests/Unit/Controller/MapTypeControllerTest.php";s:4:"0f2a";s:45:"Tests/Unit/Controller/PlaceControllerTest.php";s:4:"895b";s:46:"Tests/Unit/Controller/RegionControllerTest.php";s:4:"a118";s:39:"Tests/Unit/Domain/Model/AddressTest.php";s:4:"610b";s:40:"Tests/Unit/Domain/Model/CategoryTest.php";s:4:"ceeb";s:39:"Tests/Unit/Domain/Model/ContentTest.php";s:4:"332b";s:40:"Tests/Unit/Domain/Model/LocationTest.php";s:4:"a27a";s:44:"Tests/Unit/Domain/Model/LocationTypeTest.php";s:4:"9b99";s:35:"Tests/Unit/Domain/Model/MapTest.php";s:4:"d106";s:39:"Tests/Unit/Domain/Model/MapTypeTest.php";s:4:"208b";s:37:"Tests/Unit/Domain/Model/PlaceTest.php";s:4:"4fab";s:38:"Tests/Unit/Domain/Model/RegionTest.php";s:4:"5f7f";s:14:"doc/manual.sxw";s:4:"8d2d";}',
);

?>
