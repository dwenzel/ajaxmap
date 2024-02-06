<?php
if (!defined('TYPO3')) {
    die ('Access denied.');
}
use \DWenzel\Ajaxmap\Configuration\SettingsInterface as SI;

$configure = function () {
    $extensionKey = 'ajaxmap';
    $extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extensionKey);

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        $extensionKey,
        'Map',
        'Map'
    );

    $pluginSignature = str_replace('_', '', $extensionKey) . '_' . 'map';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/flexform_map.xml');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extensionKey, 'Configuration/TypoScript', 'Ajax Map');


    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_placegroup', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_category.xml');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_placegroup');


    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_place', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_place.xml');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_place');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_map', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_map.xml');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_map');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_region', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_region.xml');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_region');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_locationtype', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_locationtype.xml');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_locationtype');

    $GLOBALS['TCA']['tt_address']['columns'][$GLOBALS['TCA']['tt_address']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tt_address.tx_extbase_type.Tx_Ajaxmap_Address', 'Tx_Ajaxmap_Address'];

    $GLOBALS['TCA']['tt_address']['types']['Tx_Ajaxmap_Address']['showitem'] = $GLOBALS['TCA']['tt_address']['types']['1']['showitem'];
    $GLOBALS['TCA']['tt_address']['types']['Tx_Ajaxmap_Address']['showitem'] .= ',--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_address,';
    $GLOBALS['TCA']['tt_address']['types']['Tx_Ajaxmap_Address']['showitem'] .= '';

    /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Imaging\IconRegistry::class
    );

    foreach (SI::ICONS_TO_REGISTER as $identifier => $config) {
        $iconRegistry->registerIcon(
            $identifier,
            // provider
            $config[SI::ICON_PROVIDER_CLASS_KEY],
            // options
            $config[SI::ICON_OPTIONS_KEY]
        );
    }
};

$configure();
unset($configure);