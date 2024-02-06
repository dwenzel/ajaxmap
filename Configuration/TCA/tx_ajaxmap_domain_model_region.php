<?php
if (!defined ('TYPO3')) {
	die ('Access denied.');
}

$cll = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';

return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region',
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
            'default' => \DWenzel\Ajaxmap\Configuration\SettingsInterface::ICON_IDENTIFIER_REGION
        ]
    ],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid,--palette--,l10n_parent,l10n_diffsource,hidden,--palette--;;1,title,file,unselectable,selected,clickable,suppress_info_windows,preserve_viewport,main_place,regions,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime,endtime'],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
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
                    'allowLanguageSynchronization' => true
                ],
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
                    'allowLanguageSynchronization' => true
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
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('file', ['uploadfolder' => 'uploads/tx_ajaxmap'], '*'),
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
                'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_ajaxmap_domain_model_region',
				'foreign_table_where' => ' AND tx_ajaxmap_domain_model_region.uid!=###THIS_UID###',
				'MM' => 'tx_ajaxmap_region_region_mm',
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
		'main_place' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_region.main_place',
			'config' => [
				'type' => 'group',
				'allowed' => 'tx_ajaxmap_domain_model_place',
				'foreign_table' => 'tx_ajaxmap_domain_model_place',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false, 'options' => [
                            'title' => 'Edit'
                        ]
                    ],
                    'addRecord' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'Create new',
                            'table' => 'tx_ajaxmap_domain_model_place',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ]
                    ]
                ],
			]
		],
	],
];
