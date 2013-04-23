<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Map',
	array(
		'Category' => 'list, show',
		'Place' => 'list, show',
		'Map' => ' item, list, show,',
		'Region' => 'list',
		'LocationType' => 'item',
		'Content' => 'list, show',
		'Address' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Category' => '',
		'Place' => '',
		'Map' => 'item',
		'Region' => '',
		'LocationType' => '',
		'Content' => '',
		'Address' => '',
		
	)
);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

/*if(TYPO3_MODE == 'FE') {
 // For FE usage via eID
$TYPO3_CONF_VARS['FE']['eID_include']['ajaxMap'] =
t3lib_extMgm::extPath('ajaxmap').'Classes/Utility/Dispatcher.php';
}*/
// For FE usage via eID
$TYPO3_CONF_VARS['FE']['eID_include']['ajaxMap'] ='EXT:ajaxmap/Classes/Utility/Dispatcher.php';

/*
 if(TYPO3_MODE == 'FE') {
// For FE usage via eID
$TYPO3_CONF_VARS['FE']['eID_include']['ptxAjax'] =
t3lib_extMgm::extPath('pt_extbase').'Classes/Utility/eIDDispatcher.php';
}

if(TYPO3_MODE == 'BE') {
// For BE usage via ajax
$TYPO3_CONF_VARS['BE']['AJAX']['ptxAjax'] =
t3lib_extMgm::extPath('pt_extbase').'Classes/Utility/AjaxDispatcher.php:' .
'Tx_PtExtbase_Utility_AjaxDispatcher->initAndEchoDispatch';
}
*/
?>