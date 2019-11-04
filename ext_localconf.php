<?php

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$boot = function () {

    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][SI::CACHE_CHILDREN])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][SI::CACHE_CHILDREN] = [];
    }

    $settings = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ajaxmap');
    if (!empty($settings['includeJQuery'])) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ajaxmap/Resources/Private/TypoScript/jQuery.typoScript">');
    }
    if (!empty($settings['includeFancyTree'])) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ajaxmap/Resources/Private/TypoScript/fancyTree.typoScript">');
    }

    if (!empty($settings['includeGoogleMaps'])) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ajaxmap/Resources/Private/TypoScript/googleMaps.typoScript">');
    }
    if (!empty($settings['includeJavaScript'])) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ajaxmap/Resources/Private/TypoScript/javaScript.typoScript">');
    }
    TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DWenzel.' . 'ajaxmap',
        'Map',
        [
            'Place' => 'show, ajaxShow',
            'Map' => 'show,',
        ]
    );
};

$boot();
unset($boot);
