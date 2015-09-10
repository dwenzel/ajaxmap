<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
if (!empty($settings['includeJQuery'])) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Resources/Private/TypoScript/jQuery.ts">');
}
if (!empty($settings['includeDynatree'])) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'. $_EXTKEY . '/Resources/Private/TypoScript/dynaTree.ts">');
}

if (!empty($settings['includeGoogleMaps'])) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'. $_EXTKEY . '/Resources/Private/TypoScript/googleMaps.ts">');
}
if (!empty($settings['includeJavaScript'])) {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'. $_EXTKEY . '/Resources/Private/TypoScript/javaScript.ts">');
}
TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Webfox.' . $_EXTKEY,
	'Map',
	array(
		'Place' => 'list, show, ajaxShow',
		'Map' => ' item, show,',
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


// include eid dispatcher
$TYPO3_CONF_VARS['FE']['eID_include']['ajaxMap'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY).'Classes/Utility/EidDispatcher.php';
