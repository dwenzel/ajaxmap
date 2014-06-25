<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
if (!empty($settings['includeJQuery'])) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Resources/Private/TypoScript/jQuery.ts">');
}

if (!empty($settings['includeGoogleMaps'])) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'. $_EXTKEY . '/Resources/Private/TypoScript/googleMaps.ts">');
}
if (!empty($settings['includeJavaScript'])) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'. $_EXTKEY . '/Resources/Private/TypoScript/javaScript.ts">');
}
if (!empty($settings['includeDynatree'])) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'. $_EXTKEY . '/Resources/Private/TypoScript/dynaTree.ts">');
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
		'Map' => 'item',
	)
);


// For FE usage via eID
$TYPO3_CONF_VARS['FE']['eID_include']['ajaxMap'] ='EXT:ajaxmap/Classes/Utility/Dispatcher.php';
// configure allowed actions for ajax dispatcher
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['pt_extbase']['ajaxDispatcher']['allowedControllerActions']['Ajaxmap']['Map']['item'] = TRUE;
?>
