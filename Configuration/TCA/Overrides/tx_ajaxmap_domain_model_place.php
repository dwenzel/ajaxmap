<?php
if (!defined('TYPO3')) {
    die ('Access denied.');
}

$configure = function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
        'ajaxmap',
        'tx_ajaxmap_domain_model_place'
    );
};
$configure();
unset($configure);