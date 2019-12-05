<?php
defined('TYPO3_MODE') or die();

(function ($extensionKey) {
    // Add cache configurations
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][\DWenzel\Ajaxmap\Configuration\SettingsInterface::CACHE_CHILDREN])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][\DWenzel\Ajaxmap\Configuration\SettingsInterface::CACHE_CHILDREN] = [];
    }
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][\DWenzel\Ajaxmap\Configuration\SettingsInterface::CACHE_AJAX_DATA])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][\DWenzel\Ajaxmap\Configuration\SettingsInterface::CACHE_AJAX_DATA] = [];
    }

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][\DWenzel\Ajaxmap\Configuration\SettingsInterface::EXTENSION_KEY]
        = \DWenzel\Ajaxmap\Hooks\DataHandlerHook::class . '->clearCustomCachesOnRecordSave';

    // Include global JavaScript
    $settings = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get($extensionKey);
    if ($settings['includeJavaScript'] ?? false) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
            '@import "EXT:' . $extensionKey . '/Resources/Private/TypoScript/javaScript.typoScript"'
        );
    }

    // Configure plugins
    TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'DWenzel.' . $extensionKey,
        'Map',
        [
            'Place' => 'show,ajaxShow',
            'Map' => 'show,search',
        ],
        [
            'Map' => 'show,search'
        ]
    );
})('ajaxmap');
