<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_ajaxmap_domain_model_map'] = array(
	'ctrl' => $TCA['tx_ajaxmap_domain_model_map']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, type, width, height, map_center, initial_zoom, map_style, disable_default_ui, categories, regions, places, location_types',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, type, width, height, map_center, initial_zoom, map_style, disable_default_ui, categories, regions, places, location_types,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_ajaxmap_domain_model_map',
				'foreign_table_where' => 'AND tx_ajaxmap_domain_model_map.pid=###CURRENT_PID### AND tx_ajaxmap_domain_model_map.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'type' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'width' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.width',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			),
		),
		'height' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.height',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			),
		),
		'map_center' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.map_center',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'initial_zoom' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.initial_zoom',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			),
		),
		'map_style' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.map_style',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'disable_default_ui' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.disable_default_ui',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'categories' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.categories',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_category',
				'MM' => 'tx_ajaxmap_map_category_mm',
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
							'table' => 'tx_ajaxmap_domain_model_category',
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
		'regions' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.regions',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_region',
				'MM' => 'tx_ajaxmap_map_region_mm',
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
		/*'places' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.places',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_place',
				'MM' => 'tx_ajaxmap_map_place_mm',
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
							'table' => 'tx_ajaxmap_domain_model_place',
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
		),*/
		'location_types' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.location_types',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_locationtype',
				'MM' => 'tx_ajaxmap_map_locationtype_mm',
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
							'table' => 'tx_ajaxmap_domain_model_locationtype',
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
	),
);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

# overwrite settings from extension builder
# type selector
$TCA['tx_ajaxmap_domain_model_map']['columns']['type']['config']['items'] = array(
	array('Styled Map', 0),
	array('Road Map', 1),
	array('Satellite', 2),
	array('Hybrid', 3),
	array('Terrain', 4)
);

$TCA['tx_ajaxmap_domain_model_map']['interface'] = array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, type, width, height, map_center, initial_zoom, map_style, disable_default_ui, categories, regions, location_types',
);
# field order and tabs
$TCA['tx_ajaxmap_domain_model_map']['types'] = array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, type, title, width, height, map_center,--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.appearance, initial_zoom, map_style, disable_default_ui,--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.markers, categories, location_types,--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.overlays, regions,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
);
?>