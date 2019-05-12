<?php

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$boot = function () {
    $settings = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ajaxmap');
    if (!empty($settings['includeJQuery'])) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ajaxmap/Resources/Private/TypoScript/jQuery.ts">');
    }
    if (!empty($settings['includeFancyTree'])) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ajaxmap/Resources/Private/TypoScript/fancyTree.ts">');
    }

    if (!empty($settings['includeGoogleMaps'])) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ajaxmap/Resources/Private/TypoScript/googleMaps.ts">');
    }
    if (!empty($settings['includeJavaScript'])) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ajaxmap/Resources/Private/TypoScript/javaScript.ts">');
    }
    TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DWenzel.' . 'ajaxmap',
        'Map',
        [
            'Place' => 'list, show, ajaxShow',
            'Map' => ' item, show,',
            'Region' => 'list',
            'LocationType' => 'item',
            'Content' => 'list, show',
            'Address' => 'list, show',

        ],
        // non-cacheable actions
        [
            'Map' => 'item',
        ]
    );


// include eid dispatcher
    $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['ajaxMap'] = \DWenzel\Ajaxmap\Controller\AjaxController::class . '::processRequest';
};

$boot();
unset($boot);
