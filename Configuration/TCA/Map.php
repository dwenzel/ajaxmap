<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$languageFile = 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:';

$TCA['tx_ajaxmap_domain_model_map'] = array(
	'ctrl' => $TCA['tx_ajaxmap_domain_model_map']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,
		title,type,width,height,map_center,initial_zoom, map_style, disable_default_ui,
		place_groups,regions,places,location_types,categories',
	),
	'types' => array(
		'1' => array('showitem' =>
			'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1,
			type,title,width,height,map_center,

			--div--;' . $languageFile . 'tx_ajaxmap_domain_model_map.appearance,
				initial_zoom,map_style,disable_default_ui,

			--div--;' . $languageFile . 'tx_ajaxmap_domain_model_map.markers,
				place_groups,location_types,categories,
			--div--;' . $languageFile . 'tx_ajaxmap_domain_model_map.overlays,
				regions,

			--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
				starttime,endtime'
		),
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
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'type' => array(
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
					array('Styled Map', 0),
					array('Road Map', 1),
					array('Satellite', 2),
					array('Hybrid', 3),
					array('Terrain', 4)
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'width' => array(
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.width',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			),
		),
		'height' => array(
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.height',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			),
		),
		'map_center' => array(
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.map_center',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'initial_zoom' => array(
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.initial_zoom',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			),
		),
		'map_style' => array(
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.map_style',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'disable_default_ui' => array(
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.disable_default_ui',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'place_groups' => array(
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.placeGroups',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_placegroup',
				'MM' => 'tx_ajaxmap_map_placegroup_mm',
				'renderMode' => 'tree',
				'treeConfig' => array(
					'appearance' => array(
						'expandAll' => 1,
						'maxLevels' => 99,
						'showHeader' => 1
					),
					'parentField' => 'parent'
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
		'regions' => array(
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.regions',
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
		'categories' => array(
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.categories',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_category',
				'foreign_table_where' => ' AND sys_category.sys_language_uid IN (-1,0) ORDER BY sys_category.sorting ASC',
				'MM' => 'sys_category_record_mm',
				'renderMode' => 'tree',
				'treeConfig' => array(
					'appearance' => array(
						'expandAll' => 1,
						'maxLevels' => 99,
						'showHeader' => 1
					),
					'parentField' => 'parent'
				),
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
			),
		),
		'location_types' => array(
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.location_types',
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
