<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$configure = function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
        'ajaxmap',
        'tx_ajaxmap_domain_model_placei'
    );
};
$configure();
unset($configure);