<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_ajaxmap_domain_model_place'] = array(
	'ctrl' => $TCA['tx_ajaxmap_domain_model_place']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, geo_coordinates, description, info, place_groups, location_type, regions, content, address',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, geo_coordinates, description, info, place_groups, location_type, regions, content, address,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_ajaxmap_domain_model_place',
				'foreign_table_where' => 'AND tx_ajaxmap_domain_model_place.pid=###CURRENT_PID### AND tx_ajaxmap_domain_model_place.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'geo_coordinates' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place.geo_coordinates',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'info' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place.info',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'script' => 'wizard_rte.php',
						'title' => 'LLL:EXT:cms/locallang_ttc.xml:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
			'defaultExtras' => 'richtext[]',
		),
		'place_groups' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place.placeGroups',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_placegroup',
				'MM' => 'tx_ajaxmap_place_placegroup_mm',
				'renderMode' => 'tree',
				'treeConfig' => array(
					'appearance' => array(
						'expandAll' => 1,
						'maxLevels' => 99,
						'showHeader' => 1
					),
					'parentField' => 'parent',
				),
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_ajaxmap_domain_model_placegroup',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		'location_type' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place.location_type',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_locationtype',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'icon' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place.icon',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file_reference',
				'show_thumbs' => 1,
				'size' => 1,
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'disallowed' => '',
			),
		),
		'regions' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place.regions',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_region',
				'MM' => 'tx_ajaxmap_place_region_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_ajaxmap_domain_model_region',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
					'suggest' => array(    
					  	'type' => 'suggest',
					),
				),
			),
		),
		'content' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place.content',
			'config' => array(
				'type' => 'inline',
				'allowed' => 'tt_content',
				'foreign_table' => 'tt_content',
				//'foreign_field' => 'place',
				'minitems' => 0,
                'maxitems'      => 10,
				'appearance' => array(
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                    'levelLinksPosition' => 'bottom',
                    'useSortable' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showRemovedLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'showSynchronizationLink' => 1,
                    'enabledControls' => array(
                        'info' => FALSE,
                    )
                )
			),
		),
		'address' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place.address',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tt_address',
				'foreign_table' => 'tt_address',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
	),
);

$TCA['tx_ajaxmap_domain_model_place']['columns']['description']['config'] = array(
	'type' => 'text',
	'cols' => 32,
	'rows' => 5,
	'eval' => 'trim'
);

$TCA['tx_ajaxmap_domain_model_place']['interface'] = array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, location_type, title, address, description,  geo_coordinates, place_groups, regions, info, icon, content',
	);
$TCA['tx_ajaxmap_domain_model_place']['types'] = array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, location_type, title, address, description, geo_coordinates,--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place.attribution, place_groups, regions,--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_place.content, info, icon, content, --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
);
$TCA['tx_ajaxmap_domain_model_place']['palettes'] = array(
		'1' => array(
			'showitem' => '',
			''
		)
	);
?>
