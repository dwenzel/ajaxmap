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
	'state' => 'beta',
	'uploadfolder' => 1,
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '1.0.0',
	'constraints' =>
	array (
		'depends' =>
		array (
			'typo3' => '6.2.0-7.99.99',
			'tt_address' => '2.3.4-0.0.0',
			'geo_location_service' => '0.2.0-0.0.0',
		),
		'conflicts' =>
		array (
		),
		'suggests' =>
		array (
		),
	),
	'_md5_values_when_last_written' => 'a:244:{s:9:"ChangeLog";s:4:"e719";s:13:"ChangeLog.new";s:4:"567b";s:9:"README.md";s:4:"eb68";s:9:"build.xml";s:4:"dbab";s:21:"ext_conf_template.txt";s:4:"3582";s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"1ce1";s:14:"ext_tables.php";s:4:"6cb0";s:14:"ext_tables.sql";s:4:"8795";s:24:"ext_typoscript_setup.txt";s:4:"d41d";s:41:"Classes/Controller/AbstractController.php";s:4:"1eb0";s:36:"Classes/Controller/MapController.php";s:4:"e839";s:38:"Classes/Controller/PlaceController.php";s:4:"c352";s:32:"Classes/Domain/Model/Address.php";s:4:"833c";s:33:"Classes/Domain/Model/Category.php";s:4:"ab5f";s:32:"Classes/Domain/Model/Content.php";s:4:"9c46";s:37:"Classes/Domain/Model/LocationType.php";s:4:"4e97";s:28:"Classes/Domain/Model/Map.php";s:4:"741a";s:30:"Classes/Domain/Model/Place.php";s:4:"8854";s:35:"Classes/Domain/Model/PlaceGroup.php";s:4:"d1bd";s:31:"Classes/Domain/Model/Region.php";s:4:"7f77";s:42:"Classes/Domain/Model/TreeItemInterface.php";s:4:"ca8d";s:43:"Classes/Domain/Model/Dto/AbstractDemand.php";s:4:"0aa6";s:44:"Classes/Domain/Model/Dto/DemandInterface.php";s:4:"5ffe";s:40:"Classes/Domain/Model/Dto/PlaceDemand.php";s:4:"c196";s:35:"Classes/Domain/Model/Dto/Search.php";s:4:"3801";s:56:"Classes/Domain/Repository/AbstractDemandedRepository.php";s:4:"118f";s:48:"Classes/Domain/Repository/CategoryRepository.php";s:4:"d016";s:47:"Classes/Domain/Repository/ContentRepository.php";s:4:"5bd0";s:43:"Classes/Domain/Repository/MapRepository.php";s:4:"b6ae";s:50:"Classes/Domain/Repository/PlaceGroupRepository.php";s:4:"1d53";s:45:"Classes/Domain/Repository/PlaceRepository.php";s:4:"558e";s:46:"Classes/Domain/Repository/RegionRepository.php";s:4:"c27f";s:39:"Classes/DomainObject/AbstractEntity.php";s:4:"77a0";s:46:"Classes/DomainObject/SerializableInterface.php";s:4:"09d4";s:35:"Classes/Service/ChildrenService.php";s:4:"747f";s:33:"Classes/Utility/EidDispatcher.php";s:4:"f6ad";s:31:"Classes/Utility/TreeUtility.php";s:4:"14ee";s:40:"Configuration/FlexForms/flexform_map.xml";s:4:"105b";s:29:"Configuration/TCA/Address.php";s:4:"c1d8";s:29:"Configuration/TCA/Content.php";s:4:"c1d8";s:34:"Configuration/TCA/LocationType.php";s:4:"dff2";s:25:"Configuration/TCA/Map.php";s:4:"8115";s:27:"Configuration/TCA/Place.php";s:4:"d93b";s:32:"Configuration/TCA/PlaceGroup.php";s:4:"52d7";s:28:"Configuration/TCA/Region.php";s:4:"5c39";s:38:"Configuration/TypoScript/constants.txt";s:4:"9054";s:34:"Configuration/TypoScript/setup.txt";s:4:"c2c9";s:43:"Resources/Private/Language/de.locallang.xlf";s:4:"4a65";s:46:"Resources/Private/Language/de.locallang_be.xlf";s:4:"5984";s:46:"Resources/Private/Language/de.locallang_db.xlf";s:4:"208e";s:40:"Resources/Private/Language/locallang.xlf";s:4:"f933";s:40:"Resources/Private/Language/locallang.xml";s:4:"55c6";s:43:"Resources/Private/Language/locallang_be.xlf";s:4:"6125";s:55:"Resources/Private/Language/locallang_csh_tt_address.xlf";s:4:"eb1d";s:55:"Resources/Private/Language/locallang_csh_tt_address.xml";s:4:"583b";s:55:"Resources/Private/Language/locallang_csh_tt_content.xlf";s:4:"eb1d";s:55:"Resources/Private/Language/locallang_csh_tt_content.xml";s:4:"583b";s:77:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_category.xlf";s:4:"ed39";s:77:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_category.xml";s:4:"c53a";s:77:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_location.xlf";s:4:"f8c8";s:77:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_location.xml";s:4:"2482";s:81:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_locationtype.xlf";s:4:"7b37";s:81:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_locationtype.xml";s:4:"def6";s:72:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_map.xlf";s:4:"e8b7";s:72:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_map.xml";s:4:"97ff";s:76:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_maptype.xlf";s:4:"e7f4";s:76:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_maptype.xml";s:4:"af1f";s:74:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_place.xlf";s:4:"b074";s:74:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_place.xml";s:4:"fa92";s:75:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_region.xlf";s:4:"5f2d";s:75:"Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_region.xml";s:4:"a224";s:43:"Resources/Private/Language/locallang_db.xlf";s:4:"71f0";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"cfc0";s:38:"Resources/Private/Layouts/Default.html";s:4:"a61f";s:42:"Resources/Private/Partials/FormErrors.html";s:4:"3f8e";s:50:"Resources/Private/Partials/Address/Properties.html";s:4:"31f8";s:50:"Resources/Private/Partials/Content/Properties.html";s:4:"31f8";s:51:"Resources/Private/Partials/Location/FormFields.html";s:4:"4bb6";s:51:"Resources/Private/Partials/Location/Properties.html";s:4:"4e38";s:40:"Resources/Private/Partials/Map/Data.html";s:4:"d073";s:46:"Resources/Private/Partials/Map/FormFields.html";s:4:"28af";s:46:"Resources/Private/Partials/Map/Properties.html";s:4:"6faa";s:48:"Resources/Private/Partials/Place/Properties.html";s:4:"0627";s:47:"Resources/Private/Partials/Place/List/Item.html";s:4:"1680";s:49:"Resources/Private/Partials/Region/FormFields.html";s:4:"3a79";s:43:"Resources/Private/Partials/Region/Item.html";s:4:"ef5e";s:49:"Resources/Private/Partials/Region/Properties.html";s:4:"1c6e";s:45:"Resources/Private/Templates/Address/List.html";s:4:"eb5a";s:45:"Resources/Private/Templates/Address/Show.html";s:4:"cd93";s:45:"Resources/Private/Templates/Content/List.html";s:4:"550b";s:45:"Resources/Private/Templates/Content/Show.html";s:4:"61c2";s:46:"Resources/Private/Templates/Location/Edit.html";s:4:"fe85";s:46:"Resources/Private/Templates/Location/List.html";s:4:"ad98";s:45:"Resources/Private/Templates/Location/New.html";s:4:"07f1";s:46:"Resources/Private/Templates/Location/Show.html";s:4:"1783";s:41:"Resources/Private/Templates/Map/Edit.html";s:4:"ccd4";s:41:"Resources/Private/Templates/Map/List.html";s:4:"bee8";s:40:"Resources/Private/Templates/Map/New.html";s:4:"c6f0";s:41:"Resources/Private/Templates/Map/Show.html";s:4:"6062";s:47:"Resources/Private/Templates/Place/AjaxShow.html";s:4:"41ff";s:43:"Resources/Private/Templates/Place/List.html";s:4:"6f63";s:43:"Resources/Private/Templates/Place/Show.html";s:4:"db55";s:44:"Resources/Private/Templates/Region/Edit.html";s:4:"4579";s:44:"Resources/Private/Templates/Region/List.html";s:4:"786a";s:43:"Resources/Private/Templates/Region/New.html";s:4:"bdef";s:44:"Resources/Private/Templates/Region/Show.html";s:4:"e439";s:41:"Resources/Private/TypoScript/fancyTree.ts";s:4:"7131";s:42:"Resources/Private/TypoScript/googleMaps.ts";s:4:"13b9";s:38:"Resources/Private/TypoScript/jQuery.ts";s:4:"6a99";s:42:"Resources/Private/TypoScript/javaScript.ts";s:4:"db48";s:62:"Resources/Public/Contrib/jquery.dynatree-1.2.6/GPL-LICENSE.txt";s:4:"2c17";s:62:"Resources/Public/Contrib/jquery.dynatree-1.2.6/MIT-License.txt";s:4:"c34d";s:65:"Resources/Public/Contrib/jquery.dynatree-1.2.6/jquery.dynatree.js";s:4:"52a4";s:69:"Resources/Public/Contrib/jquery.dynatree-1.2.6/jquery.dynatree.min.js";s:4:"9a37";s:65:"Resources/Public/Contrib/jquery.dynatree-1.2.6/skin/icons-rtl.gif";s:4:"92dc";s:61:"Resources/Public/Contrib/jquery.dynatree-1.2.6/skin/icons.gif";s:4:"d3e3";s:63:"Resources/Public/Contrib/jquery.dynatree-1.2.6/skin/loading.gif";s:4:"3328";s:67:"Resources/Public/Contrib/jquery.dynatree-1.2.6/skin/ui.dynatree.css";s:4:"807c";s:65:"Resources/Public/Contrib/jquery.dynatree-1.2.6/skin/vline-rtl.gif";s:4:"b20d";s:61:"Resources/Public/Contrib/jquery.dynatree-1.2.6/skin/vline.gif";s:4:"61e8";s:67:"Resources/Public/Contrib/jquery.dynatree-1.2.6/skin-vista/icons.gif";s:4:"5d82";s:69:"Resources/Public/Contrib/jquery.dynatree-1.2.6/skin-vista/loading.gif";s:4:"36cb";s:73:"Resources/Public/Contrib/jquery.dynatree-1.2.6/skin-vista/ui.dynatree.css";s:4:"32ee";s:59:"Resources/Public/Contrib/jquery.dynatree-1.2.7/CHANGELOG.md";s:4:"172e";s:62:"Resources/Public/Contrib/jquery.dynatree-1.2.7/GPL-LICENSE.txt";s:4:"2c17";s:62:"Resources/Public/Contrib/jquery.dynatree-1.2.7/MIT-License.txt";s:4:"f77f";s:56:"Resources/Public/Contrib/jquery.dynatree-1.2.7/README.md";s:4:"f9f1";s:65:"Resources/Public/Contrib/jquery.dynatree-1.2.7/jquery.dynatree.js";s:4:"43c9";s:69:"Resources/Public/Contrib/jquery.dynatree-1.2.7/jquery.dynatree.min.js";s:4:"4ccf";s:65:"Resources/Public/Contrib/jquery.dynatree-1.2.7/skin/icons-rtl.gif";s:4:"92dc";s:61:"Resources/Public/Contrib/jquery.dynatree-1.2.7/skin/icons.gif";s:4:"d3e3";s:63:"Resources/Public/Contrib/jquery.dynatree-1.2.7/skin/loading.gif";s:4:"3328";s:67:"Resources/Public/Contrib/jquery.dynatree-1.2.7/skin/ui.dynatree.css";s:4:"8684";s:65:"Resources/Public/Contrib/jquery.dynatree-1.2.7/skin/vline-rtl.gif";s:4:"b20d";s:61:"Resources/Public/Contrib/jquery.dynatree-1.2.7/skin/vline.gif";s:4:"61e8";s:67:"Resources/Public/Contrib/jquery.dynatree-1.2.7/skin-vista/icons.gif";s:4:"5d82";s:69:"Resources/Public/Contrib/jquery.dynatree-1.2.7/skin-vista/loading.gif";s:4:"36cb";s:73:"Resources/Public/Contrib/jquery.dynatree-1.2.7/skin-vista/ui.dynatree.css";s:4:"a7a2";s:71:"Resources/Public/Contrib/jquery.fancytree-2.9.0/jquery.fancytree-all.js";s:4:"a2e4";s:75:"Resources/Public/Contrib/jquery.fancytree-2.9.0/jquery.fancytree-all.min.js";s:4:"bcd6";s:67:"Resources/Public/Contrib/jquery.fancytree-2.9.0/jquery.fancytree.js";s:4:"2ca5";s:71:"Resources/Public/Contrib/jquery.fancytree-2.9.0/jquery.fancytree.min.js";s:4:"4294";s:77:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-awesome/ui.fancytree.css";s:4:"dffa";s:78:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-awesome/ui.fancytree.less";s:4:"0c8a";s:81:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-awesome/ui.fancytree.min.css";s:4:"8165";s:79:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-bootstrap/ui.fancytree.css";s:4:"56b1";s:80:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-bootstrap/ui.fancytree.less";s:4:"6a35";s:83:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-bootstrap/ui.fancytree.min.css";s:4:"b5d8";s:81:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-bootstrap-n/ui.fancytree.css";s:4:"444d";s:82:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-bootstrap-n/ui.fancytree.less";s:4:"20fd";s:85:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-bootstrap-n/ui.fancytree.min.css";s:4:"8dca";s:67:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-lion/icons.gif";s:4:"afa1";s:69:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-lion/loading.gif";s:4:"7b97";s:74:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-lion/ui.fancytree.css";s:4:"14e7";s:75:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-lion/ui.fancytree.less";s:4:"9479";s:78:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-lion/ui.fancytree.min.css";s:4:"c27a";s:74:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-themeroller/icons.gif";s:4:"55bf";s:76:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-themeroller/loading.gif";s:4:"b08c";s:81:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-themeroller/ui.fancytree.css";s:4:"9ed6";s:85:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-themeroller/ui.fancytree.min.css";s:4:"def3";s:68:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-vista/icons.gif";s:4:"4f02";s:70:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-vista/loading.gif";s:4:"b08c";s:75:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-vista/ui.fancytree.css";s:4:"1c68";s:76:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-vista/ui.fancytree.less";s:4:"97dc";s:79:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-vista/ui.fancytree.min.css";s:4:"4494";s:67:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win7/icons.gif";s:4:"4f02";s:69:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win7/loading.gif";s:4:"b08c";s:74:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win7/ui.fancytree.css";s:4:"c497";s:75:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win7/ui.fancytree.less";s:4:"7d5b";s:78:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win7/ui.fancytree.min.css";s:4:"b6c6";s:67:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8/icons.gif";s:4:"55bf";s:69:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8/loading.gif";s:4:"b08c";s:74:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8/ui.fancytree.css";s:4:"6fac";s:75:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8/ui.fancytree.less";s:4:"5405";s:78:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8/ui.fancytree.min.css";s:4:"3780";s:69:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8-n/icons.gif";s:4:"55bf";s:71:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8-n/loading.gif";s:4:"b08c";s:76:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8-n/ui.fancytree.css";s:4:"ce03";s:77:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8-n/ui.fancytree.less";s:4:"3af9";s:80:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8-n/ui.fancytree.min.css";s:4:"4cfc";s:71:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8-xxl/icons.gif";s:4:"ba20";s:73:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8-xxl/loading.gif";s:4:"d1b9";s:78:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8-xxl/ui.fancytree.css";s:4:"1495";s:79:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8-xxl/ui.fancytree.less";s:4:"6560";s:82:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-win8-xxl/ui.fancytree.min.css";s:4:"573a";s:69:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-xp/icons-rtl.gif";s:4:"92dc";s:65:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-xp/icons.gif";s:4:"d3e3";s:67:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-xp/loading.gif";s:4:"3328";s:72:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-xp/ui.fancytree.css";s:4:"a03d";s:73:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-xp/ui.fancytree.less";s:4:"d2b3";s:76:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-xp/ui.fancytree.min.css";s:4:"0af4";s:69:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-xp/vline-rtl.gif";s:4:"b20d";s:65:"Resources/Public/Contrib/jquery.fancytree-2.9.0/skin-xp/vline.gif";s:4:"61e8";s:84:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.childcounter.js";s:4:"f41f";s:78:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.clones.js";s:4:"f74d";s:82:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.columnview.js";s:4:"e928";s:77:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.debug.js";s:4:"d8cf";s:75:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.dnd.js";s:4:"b40f";s:76:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.edit.js";s:4:"4b84";s:78:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.filter.js";s:4:"b249";s:77:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.glyph.js";s:4:"6cd4";s:79:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.gridnav.js";s:4:"3d1b";s:71:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.js";s:4:"2ca5";s:76:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.menu.js";s:4:"2b5d";s:79:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.persist.js";s:4:"83ff";s:77:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.table.js";s:4:"1ad2";s:83:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.themeroller.js";s:4:"8fba";s:76:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/jquery.fancytree.wide.js";s:4:"d610";s:68:"Resources/Public/Contrib/jquery.fancytree-2.9.0/src/skin-common.less";s:4:"8586";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:37:"Resources/Public/Icons/tt_address.gif";s:4:"1103";s:37:"Resources/Public/Icons/tt_content.gif";s:4:"1103";s:59:"Resources/Public/Icons/tx_ajaxmap_domain_model_category.gif";s:4:"905a";s:59:"Resources/Public/Icons/tx_ajaxmap_domain_model_location.gif";s:4:"905a";s:63:"Resources/Public/Icons/tx_ajaxmap_domain_model_locationtype.gif";s:4:"4e5b";s:54:"Resources/Public/Icons/tx_ajaxmap_domain_model_map.gif";s:4:"905a";s:56:"Resources/Public/Icons/tx_ajaxmap_domain_model_place.gif";s:4:"905a";s:57:"Resources/Public/Icons/tx_ajaxmap_domain_model_region.gif";s:4:"905a";s:42:"Resources/Public/JavaScript/ajaxmapMain.js";s:4:"d50a";s:55:"Resources/Public/JavaScript/Lib/jQuery/jquery-1.11.1.js";s:4:"3d93";s:54:"Resources/Public/JavaScript/Lib/jQuery/jquery-2.1.1.js";s:4:"7403";s:58:"Resources/Public/JavaScript/Lib/jQuery/jquery-ui.custom.js";s:4:"3eff";s:55:"Resources/Public/JavaScript/Lib/jQuery/jquery.cookie.js";s:4:"d552";s:57:"Resources/Public/JavaScript/Lib/jQuery/jquery.dynatree.js";s:4:"52a4";s:63:"Resources/Public/JavaScript/Lib/jQuery-1.10/jquery-ui.custom.js";s:4:"4ef5";s:60:"Resources/Public/JavaScript/Lib/jQuery-1.10/jquery.cookie.js";s:4:"49be";s:53:"Resources/Public/JavaScript/Lib/jQuery-1.10/jquery.js";s:4:"9151";s:25:"Tests/Build/UnitTests.xml";s:4:"7c34";s:43:"Tests/Unit/Controller/MapControllerTest.php";s:4:"de16";s:45:"Tests/Unit/Controller/PlaceControllerTest.php";s:4:"33cc";s:39:"Tests/Unit/Domain/Model/AddressTest.php";s:4:"ad1e";s:40:"Tests/Unit/Domain/Model/CategoryTest.php";s:4:"77ec";s:39:"Tests/Unit/Domain/Model/ContentTest.php";s:4:"6967";s:44:"Tests/Unit/Domain/Model/LocationTypeTest.php";s:4:"b7ab";s:35:"Tests/Unit/Domain/Model/MapTest.php";s:4:"b708";s:42:"Tests/Unit/Domain/Model/PlaceGroupTest.php";s:4:"6212";s:37:"Tests/Unit/Domain/Model/PlaceTest.php";s:4:"fcf6";s:38:"Tests/Unit/Domain/Model/RegionTest.php";s:4:"2a1c";s:50:"Tests/Unit/Domain/Model/Dto/AbstractDemandTest.php";s:4:"6611";s:47:"Tests/Unit/Domain/Model/Dto/PlaceDemandTest.php";s:4:"cc65";s:42:"Tests/Unit/Domain/Model/Dto/SearchTest.php";s:4:"f7ea";s:46:"Tests/Unit/DomainObject/AbstractEntityTest.php";s:4:"1114";s:14:"doc/manual.sxw";s:4:"8d2d";}',
);

