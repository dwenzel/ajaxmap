<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Map',
	'Map'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_' . map;
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_' .map. '.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Ajax Map');

			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_category', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_category.xml');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_category');
			$TCA['tx_ajaxmap_domain_model_category'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_category',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Category.php',
					'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmap_domain_model_category.gif'
				),
			);

			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_place', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_place.xml');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_place');
			$TCA['tx_ajaxmap_domain_model_place'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Place.php',
					'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmap_domain_model_place.gif'
				),
			);

			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_map', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_map.xml');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_map');
			$TCA['tx_ajaxmap_domain_model_map'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Map.php',
					'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmap_domain_model_map.gif'
				),
			);

			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_region', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_region.xml');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_region');
			$TCA['tx_ajaxmap_domain_model_region'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Region.php',
					'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmap_domain_model_region.gif'
				),
			);

			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_locationtype', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_locationtype.xml');
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_locationtype');
			$TCA['tx_ajaxmap_domain_model_locationtype'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_locationtype',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/LocationType.php',
					'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmap_domain_model_locationtype.gif'
				),
			);
##test dw
# this leads to a missing table error!
#			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_content', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_contentxml');
#			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_content');
#			$TCA['tx_ajaxmap_domain_model_content'] = array(
#				'ctrl' => array(
#					'title'	=> 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_content',
#					'label' => 'title',
#					'tstamp' => 'tstamp',
#					'crdate' => 'crdate',
#					'cruser_id' => 'cruser_id',
#					'dividers2tabs' => TRUE,
#					'versioningWS' => 2,
#					'versioning_followPages' => TRUE,
#					'origUid' => 't3_origuid',
#					'languageField' => 'sys_language_uid',
#					'transOrigPointerField' => 'l10n_parent',
#					'transOrigDiffSourceField' => 'l10n_diffsource',
#					'delete' => 'deleted',
#					'enablecolumns' => array(
#						'disabled' => 'hidden',
#						'starttime' => 'starttime',
#						'endtime' => 'endtime',
#					),
#					'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Content.php',
#					'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmap_domain_model_content.gif'
#				),
#			);
## test ende




/*
			$tmp_ajaxmap_columns = array(

);

$tmp_ajaxmap_columns['place'] = array(
	'config' => array(
		'type' => 'passthrough',
	)
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content',$tmp_ajaxmap_columns);

//$TCA['tt_content']['columns'][$TCA['tt_content']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tt_content.tx_extbase_type.Tx_Ajaxmap_Content','Tx_Ajaxmap_Content');

$TCA['tt_content']['types']['Tx_Ajaxmap_Domain_Model_Content'] = $TCA['tt_content']['types']['0'];
$TCA['tt_content']['types']['Tx_Ajaxmap_Domain_Model_Content']['showitem'] = $TCA['tt_content']['types']['0']['showitem'];
$TCA['tt_content']['types']['Tx_Ajaxmap_Domain_Model_Content']['showitem'] .= ',--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_content,';
//$TCA['tt_content']['types']['Tx_Ajaxmap_Domain_Model_Content']['showitem'] .= '';
*/
$tmp_ajaxmap_columns = array(

);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_address',$tmp_ajaxmap_columns);

$TCA['tt_address']['columns'][$TCA['tt_address']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tt_address.tx_extbase_type.Tx_Ajaxmap_Address','Tx_Ajaxmap_Address');

$TCA['tt_address']['types']['Tx_Ajaxmap_Address']['showitem'] = $TCA['tt_address']['types']['1']['showitem'];
$TCA['tt_address']['types']['Tx_Ajaxmap_Address']['showitem'] .= ',--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_address,';
$TCA['tt_address']['types']['Tx_Ajaxmap_Address']['showitem'] .= '';
			
?>
