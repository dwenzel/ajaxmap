<?php
if (!defined ('TYPO3')) {
	die ('Access denied.');
}
$languageFile = 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:';
$cll = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
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
	'types' => [
		'1' => ['showitem' =>
			'sys_language_uid,--palette--,l10n_parent,l10n_diffsource,hidden,--palette--;;1,type,--palette--;;controls,title,width,height,map_center,--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.appearance,--palette--;;zoomLevels,map_style,disable_default_ui,--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.markers,place_groups,location_types,categories,--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_map.overlays,regions,static_layers,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime,endtime'
		],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
        'controls' => [
            'showitem' => 'hide_type_control, hide_fullscreen_control, hide_street_view_control',
        ],
        'zoomLevels' => [
            'label' => $languageFile . 'tx_ajaxmap_domain_model_map.zoomLevels',
            'showitem' => 'initial_zoom, min_zoom, max_zoom',
        ],
	],
	'columns' => [
		'sys_language_uid' => [
			'exclude' => 1,
			'label' => $cll . 'LGL.language',
			'config' => ['type' => 'language'],
		],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'label' => $cll . 'LGL.l18n_parent',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectSingle',
				'items' => [
					['label' => '', 'value' => 0],
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
			'label' => $cll . 'LGL.starttime',
			'config' => [
				'type' => 'datetime',
				'size' => 13,
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				],
                'renderType' => 'inputDateTime',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ]
			],
		],
		'endtime' => [
			'exclude' => 1,
			'label' => $cll . 'LGL.endtime',
			'config' => [
				'type' => 'datetime',
				'size' => 13,
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				],
                'renderType' => 'inputDateTime',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ]
			],
		],
		'title' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
                'required' => true
			],
		],
		'type' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.type',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectSingle',
				'items' => [
					['label' => '', 'value' => 0],
					['label' => 'Styled Map', 'value' => 0],
					['label' => 'Road Map', 'value' => 1],
					['label' => 'Satellite', 'value' => 2],
					['label' => 'Hybrid', 'value' => 3],
					['label' => 'Terrain', 'value' => 4]
				],
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			],
		],
        'hide_type_control' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_ajaxmap_domain_model_map.hide_type_control',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'hide_fullscreen_control' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_ajaxmap_domain_model_map.hide_fullscreen_control',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'hide_street_view_control' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_ajaxmap_domain_model_map.hide_street_view_control',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
		'width' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.width',
			'config' => [
				'type' => 'number',
				'size' => 4,
				'required' => true
			],
		],
		'height' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.height',
			'config' => [
				'type' => 'number',
				'size' => 4,
				'required' => true
			],
		],
		'map_center' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.map_center',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
                'required' => true
			],
		],
		'initial_zoom' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.initial_zoom',
			'config' => [
				'type' => 'number',
				'size' => 4,
				'required' => true
			],
		],
		'min_zoom' => [
			'exclude' => true,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.min_zoom',
			'config' => [
				'type' => 'number',
				'size' => 4,
                'default' => null,
                'mode' => 'useOrOverridePlaceholder',
                'nullable' => true,
                'nullable' => true,
			],
		],
		'max_zoom' => [
			'exclude' => true,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.max_zoom',
			'config' => [
				'type' => 'number',
				'size' => 4,
                'default' => null,
                'mode' => 'useOrOverridePlaceholder',
                'nullable' => true,
                'nullable' => true,
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
                'renderType' => 'selectTree',
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
				'size' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'Edit'
                        ]
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'Create new',
                            'table' => 'tx_ajaxmap_domain_model_placegroup',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ]
                    ]
                ],
			],
		],
		'regions' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.regions',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_ajaxmap_domain_model_region',
				'MM' => 'tx_ajaxmap_map_region_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'Edit'
                        ]
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'Create new',
                            'table' => 'tx_ajaxmap_domain_model_region',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ]
                    ]
                ],
			],
		],
		'static_layers' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.static_layers',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_ajaxmap_domain_model_region',
				'MM' => 'tx_ajaxmap_map_static_layer_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'Edit'
                        ]
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'Create new',
                            'table' => 'tx_ajaxmap_domain_model_region',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ]
                    ]
                ],
			],
		],
		'categories' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.categories',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectTree',
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
				'size' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
			],
		],
		'location_types' => [
			'exclude' => 0,
			'label' => $languageFile . 'tx_ajaxmap_domain_model_map.location_types',
			'config' => [
				'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_ajaxmap_domain_model_locationtype',
				'MM' => 'tx_ajaxmap_map_locationtype_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'Edit'
                        ]
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'Create new',
                            'table' => 'tx_ajaxmap_domain_model_locationtype',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ]
                    ]
                ],
			],
		],
	],
];
