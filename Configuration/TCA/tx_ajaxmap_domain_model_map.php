<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
$languageFile = 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:';
$cll = 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:';

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'versioningWS' => 2,
        'versioning_followPages' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'typeicon_classes' => [
            'default' => \DWenzel\Ajaxmap\Configuration\SettingsInterface::ICON_IDENTIFIER_MAP
        ]
    ],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,
		title,type,width,height,map_center,initial_zoom, map_style, disable_default_ui,
		place_groups,regions,static_layers,location_types,categories',
	],
	'types' => [
		'1' => ['showitem' =>
			'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1,
			type,title,width,height,map_center,

			--div--;' . $languageFile . 'tx_ajaxmap_domain_model_map.appearance,
				initial_zoom,map_style,disable_default_ui,

			--div--;' . $languageFile . 'tx_ajaxmap_domain_model_map.markers,
				place_groups,location_types,categories,
			--div--;' . $languageFile . 'tx_ajaxmap_domain_model_map.overlays,
				regions,static_layers,

			--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
				starttime,endtime'
		],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [
		'sys_language_uid' => [
			'exclude' => 1,
			'label' => $cll . 'LGL.language',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => [
					[$cll . 'LGL.allLanguages', -1],
					[$cll . 'LGL.default_value', 0]
				],
			],
		],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => $cll . 'LGL.l18n_parent',
			'config' => [
				'type' => 'select',
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tx_ajaxmap_domain_model_map',
				'foreign_table_where' => 'AND tx_ajaxmap_domain_model_map.pid=###CURRENT_PID### AND tx_ajaxmap_domain_model_map.sys_language_uid IN (-1,0)',
			],
		],
		'l10n_diffsource' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
		't3ver_label' => [
			'label' => $cll . 'LGL.versionLabel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			]
		],
		'hidden' => [
			'exclude' => 1,
			'label' => $cll . 'LGL.hidden',
			'config' => [
				'type' => 'check',
			],
		],
		'starttime' => [
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => $cll . 'LGL.starttime',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				],
			],
		],
		'endtime' => [
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => $cll . 'LGL.endtime',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				],
			],
		],
		'title' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			],
		],
		'type' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.type',
			'config' => [
				'type' => 'select',
				'items' => [
					['', 0],
					['Styled Map', 0],
					['Road Map', 1],
					['Satellite', 2],
					['Hybrid', 3],
					['Terrain', 4]
				],
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			],
		],
		'width' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.width',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			],
		],
		'height' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.height',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			],
		],
		'map_center' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.map_center',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			],
		],
		'initial_zoom' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.initial_zoom',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			],
		],
		'map_style' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.map_style',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			],
		],
		'disable_default_ui' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.disable_default_ui',
			'config' => [
				'type' => 'check',
				'default' => 0
			],
		],
		'place_groups' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.placeGroups',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_placegroup',
				'MM' => 'tx_ajaxmap_map_placegroup_mm',
				'renderMode' => 'tree',
				'treeConfig' => [
					'appearance' => [
						'expandAll' => 1,
						'maxLevels' => 99,
						'showHeader' => 1
					],
					'parentField' => 'parent'
				],
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => [
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => [
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						],
					'add' => [
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => [
							'table' => 'tx_ajaxmap_domain_model_placegroup',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							],
						'script' => 'wizard_add.php',
					],
				],
			],
		],
		'regions' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.regions',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_region',
				'MM' => 'tx_ajaxmap_map_region_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => [
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => [
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						],
					'add' => [
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => [
							'table' => 'tx_ajaxmap_domain_model_region',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							],
						'script' => 'wizard_add.php',
					],
                    'suggest' => [    
                        'type' => 'suggest',
                    ],
				],
			],
		],
		'static_layers' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.static_layers',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_region',
				'MM' => 'tx_ajaxmap_map_static_layer_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => [
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => [
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						],
					'add' => [
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => [
							'table' => 'tx_ajaxmap_domain_model_region',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							],
						'script' => 'wizard_add.php',
					],
                    'suggest' => [    
                        'type' => 'suggest',
                    ],
				],
			],
		],
		'categories' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.categories',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'sys_category',
				'foreign_table_where' => ' AND sys_category.sys_language_uid IN (-1,0) ORDER BY sys_category.sorting ASC',
				'MM' => 'sys_category_record_mm',
				'renderMode' => 'tree',
				'treeConfig' => [
					'appearance' => [
						'expandAll' => 1,
						'maxLevels' => 99,
						'showHeader' => 1
					],
					'parentField' => 'parent'
				],
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
			],
		],
		'location_types' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.location_types',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_locationtype',
				'MM' => 'tx_ajaxmap_map_locationtype_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => [
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => [
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						],
					'add' => [
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => [
							'table' => 'tx_ajaxmap_domain_model_locationtype',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							],
						'script' => 'wizard_add.php',
					],
                    'suggest' => [    
                        'type' => 'suggest',
                    ],
				],
			],
		],
	],
];
