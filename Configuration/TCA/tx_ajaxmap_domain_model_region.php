<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$cll = 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:';

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region',
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
        'iconfile' => 'EXT:ajaxmap/Resources/Public/Icons/tx_ajaxmap_domain_model_region.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, file, unselectable, selected, clickable, suppress_info_windows, preserve_viewport,regions,main_place',
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, file, unselectable, selected, clickable, suppress_info_windows, preserve_viewport,main_place,regions,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'],
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
				'foreign_table' => 'tx_ajaxmap_domain_model_region',
				'foreign_table_where' => 'AND tx_ajaxmap_domain_model_region.pid=###CURRENT_PID### AND tx_ajaxmap_domain_model_region.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'file' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region.file',
			'config' => [
				'type' => 'group',
				'internal_type' => 'file_reference',
				'uploadfolder' => 'uploads/tx_ajaxmap',
				'allowed' => '*',
				'disallowed' => 'php',
				'size' => 5,
			],
		],
		'clickable' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region.clickable',
			'config' => [
				'type' => 'check',
				'default' => 0
			],
		],
		'unselectable' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region.unselectable',
			'config' => [
				'type' => 'check',
				'default' => 0
			],
		],
		'selected' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region.selected',
			'config' => [
				'type' => 'check',
				'default' => 0
			],
		],
		'suppress_info_windows' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region.suppress_info_windows',
			'config' => [
				'type' => 'check',
				'default' => 0
			],
		],
		'preserve_viewport' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region.preserve_viewport',
			'config' => [
				'type' => 'check',
				'default' => 0
			],
		],
		'regions' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region.regions',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_ajaxmap_domain_model_region',
				'foreign_table_where' => ' AND tx_ajaxmap_domain_model_region.uid!=###THIS_UID###',
				'MM' => 'tx_ajaxmap_region_region_mm',
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
		'main_place' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region.main_place',
			'config' => [
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_ajaxmap_domain_model_place',
				'foreign_table' => 'tx_ajaxmap_domain_model_place',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
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
							'table' => 'tx_ajaxmap_domain_model_place',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						],
						'script' => 'wizard_add.php',
					],
					'suggest' => [
						'type' => 'suggest',
					],
				],
			]
		],
	],
];
