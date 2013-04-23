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
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_' .map. '.xml');

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Ajax Map');

			t3lib_extMgm::addLLrefForTCAdescr('tx_ajaxmap_domain_model_category', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_category.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_ajaxmap_domain_model_category');
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
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Category.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmap_domain_model_category.gif'
				),
			);

			t3lib_extMgm::addLLrefForTCAdescr('tx_ajaxmap_domain_model_place', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_place.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_ajaxmap_domain_model_place');
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
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Place.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmap_domain_model_place.gif'
				),
			);

			t3lib_extMgm::addLLrefForTCAdescr('tx_ajaxmap_domain_model_map', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_map.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_ajaxmap_domain_model_map');
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
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Map.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmap_domain_model_map.gif'
				),
			);

			t3lib_extMgm::addLLrefForTCAdescr('tx_ajaxmap_domain_model_region', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_region.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_ajaxmap_domain_model_region');
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
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Region.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmap_domain_model_region.gif'
				),
			);

			t3lib_extMgm::addLLrefForTCAdescr('tx_ajaxmap_domain_model_locationtype', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_locationtype.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_ajaxmap_domain_model_locationtype');
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
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/LocationType.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmap_domain_model_locationtype.gif'
				),
			);
##test dw
# this leads to a missing table error!
#			t3lib_extMgm::addLLrefForTCAdescr('tx_ajaxmap_domain_model_content', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_contentxml');
#			t3lib_extMgm::allowTableOnStandardPages('tx_ajaxmap_domain_model_content');
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
#					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Content.php',
#					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_ajaxmap_domain_model_content.gif'
#				),
#			);
## test ende

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder



/*
			$tmp_ajaxmap_columns = array(

);

$tmp_ajaxmap_columns['place'] = array(
	'config' => array(
		'type' => 'passthrough',
	)
);

t3lib_extMgm::addTCAcolumns('tt_content',$tmp_ajaxmap_columns);

//$TCA['tt_content']['columns'][$TCA['tt_content']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tt_content.tx_extbase_type.Tx_Ajaxmap_Content','Tx_Ajaxmap_Content');

$TCA['tt_content']['types']['Tx_Ajaxmap_Domain_Model_Content'] = $TCA['tt_content']['types']['0'];
$TCA['tt_content']['types']['Tx_Ajaxmap_Domain_Model_Content']['showitem'] = $TCA['tt_content']['types']['0']['showitem'];
$TCA['tt_content']['types']['Tx_Ajaxmap_Domain_Model_Content']['showitem'] .= ',--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_content,';
//$TCA['tt_content']['types']['Tx_Ajaxmap_Domain_Model_Content']['showitem'] .= '';
*/
$tmp_ajaxmap_columns = array(

);

t3lib_extMgm::addTCAcolumns('tt_address',$tmp_ajaxmap_columns);

$TCA['tt_address']['columns'][$TCA['tt_address']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tt_address.tx_extbase_type.Tx_Ajaxmap_Address','Tx_Ajaxmap_Address');

$TCA['tt_address']['types']['Tx_Ajaxmap_Address']['showitem'] = $TCA['tt_address']['types']['1']['showitem'];
$TCA['tt_address']['types']['Tx_Ajaxmap_Address']['showitem'] .= ',--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_address,';
$TCA['tt_address']['types']['Tx_Ajaxmap_Address']['showitem'] .= '';
			
?>