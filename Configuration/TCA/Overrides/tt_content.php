<?php

$configure = function () {

    $vendor = \DWenzel\Ajaxmap\Configuration\SettingsInterface::VENDOR_NAME;
    $extensionKey = \DWenzel\Ajaxmap\Configuration\SettingsInterface::EXTENSION_KEY;

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        $vendor . '.' . $extensionKey,
        'Map',
        'Map'
    );

    $pluginSignature = str_replace('_', '', $extensionKey) . '_' . 'map';

    //$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages,recursive';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        $pluginSignature,
        'FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/flexform_map.xml'
    );
};
$configure();
unset($configure);