<?php
if (!defined('TYPO3')) {
    die ('Access denied.');
}

$cll = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';
$ll = 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_ajaxmap_domain_model_place',
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
            'default' => \DWenzel\Ajaxmap\Configuration\SettingsInterface::ICON_IDENTIFIER_PLACE
        ]
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid,--palette--,l10n_parent,l10n_diffsource,hidden,--palette--;;1,title,latitude,longitude,icon,description,info,categories,place_groups,location_type,regions,content,address,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime,endtime'],
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
                'foreign_table' => 'tx_ajaxmap_domain_model_place',
                'foreign_table_where' => 'AND tx_ajaxmap_domain_model_place.pid=###CURRENT_PID### AND tx_ajaxmap_domain_model_place.sys_language_uid IN (-1,0)',
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
            'label' => $ll . 'tx_ajaxmap_domain_model_place.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true
            ],
        ],
        'description' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ],
        ],
        'info' => [
            'exclude' => 1,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.info',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                        'options' => [
                            'title' => 'LLL:EXT:cms/locallang_ttc.xml:bodytext.W.RTE'
                        ]
                    ]
                ]
            ],
        ],
        'place_groups' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.placeGroups',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'tx_ajaxmap_domain_model_placegroup',
                'MM' => 'tx_ajaxmap_place_placegroup_mm',
                'renderMode' => 'tree',
                'treeConfig' => [
                    'appearance' => [
                        'expandAll' => 1,
                        'maxLevels' => 99,
                        'showHeader' => 1
                    ],
                    'parentField' => 'parent',
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
        'location_type' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.location_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_ajaxmap_domain_model_locationtype',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'icon' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.icon',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('icon', [], $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']),
        ],
        'regions' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.regions',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_ajaxmap_domain_model_region',
                'MM' => 'tx_ajaxmap_place_region_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'fieldControl' => [
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
        'content' => [
            'exclude' => 1,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.content',
            'config' => [
                'type' => 'inline',
                'allowed' => 'tt_content',
                'foreign_table' => 'tt_content',
                //'foreign_field' => 'place',
                'minitems' => 0,
                'maxitems' => 10,
                'appearance' => [
                    'collapseAll' => 1,
                    'expandSingle' => 1,
                    'levelLinksPosition' => 'bottom',
                    'useSortable' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showRemovedLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'showSynchronizationLink' => 1,
                    'enabledControls' => [
                        'info' => false,
                    ]
                ]
            ],
        ],
        'latitude' => [
            'exclude' => true,
            'label' => $ll . 'latitude',
            'config' => [
                'type' => 'input',
                'eval' => 'FriendsOfTYPO3\TtAddress\Evaluation\LatitudeEvaluation',
                'default' => null,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'nullable' => true,
            ]
        ],
        'longitude' => [
            'exclude' => true,
            'label' => $ll . 'longitude',
            'config' => [
                'type' => 'input',
                'eval' => 'FriendsOfTYPO3\TtAddress\Evaluation\LongitudeEvaluation',
                'default' => null,
                'fieldControl' => [
                    'locationMap' => [
                        'renderType' => 'locationMapWizard'
                    ]
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'nullable' => true,
            ]
        ],
        'address' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.address',
            'config' => [
                'type' => 'group',
                'allowed' => 'tt_address',
                'foreign_table' => 'tt_address',
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => false,
                    ],
                    'addRecord' => [
                        'disabled' => false,
                    ],
                    'listModule' => [
                        'disabled' => false,
                    ],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'categories' => [
            'config' => [
                'type' => 'category'
            ]
        ],
    ],
];
