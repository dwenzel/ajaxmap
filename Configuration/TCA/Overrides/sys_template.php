<?php

defined('TYPO3') or die('Access denied.');

// TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'ajaxmap',
    'Configuration/TypoScript/',
    'Ajaxmap - Base Configuration'
);
