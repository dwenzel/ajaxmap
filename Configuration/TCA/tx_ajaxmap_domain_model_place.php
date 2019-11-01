<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$cll = 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:';
$ll = 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_ajaxmap_domain_model_place',
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
            'default' => \DWenzel\Ajaxmap\Configuration\SettingsInterface::ICON_IDENTIFIER_PLACE
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title,latitude,longitude,icon,description, info, place_groups, location_type, regions, content, address',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title,latitude,longitude,icon, description, info, categories, place_groups, location_type, regions, content, address,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'],
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
            'label' => $ll . 'tx_ajaxmap_domain_model_place.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
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
                'wizards' => [
                    'RTE' => [
                        'icon' => 'wizard_rte2.gif',
                        'notNewRecords' => 1,
                        'RTEonly' => 1,
                        'script' => 'wizard_rte.php',
                        'title' => 'LLL:EXT:cms/locallang_ttc.xml:bodytext.W.RTE',
                        'type' => 'script'
                    ]
                ]
            ],
            'defaultExtras' => 'richtext[]',
        ],
        'place_groups' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.placeGroups',
            'config' => [
                'type' => 'select',
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
        'location_type' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.location_type',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_ajaxmap_domain_model_locationtype',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'icon' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.icon',
            'config' => [
                'type' => 'group',
                'internal_type' => 'file_reference',
                'show_thumbs' => 1,
                'size' => 1,
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'disallowed' => '',
            ],
        ],
        'regions' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.regions',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_ajaxmap_domain_model_region',
                'MM' => 'tx_ajaxmap_place_region_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'wizards' => [
                    '_PADDING' => 1,
                    '_VERTICAL' => 1,
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
                'eval' => 'null,' . \FriendsOfTYPO3\TtAddress\Evaluation\LatitudeEvaluation::class,
                'default' => null,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'longitude' => [
            'exclude' => true,
            'label' => $ll . 'longitude',
            'config' => [
                'type' => 'input',
                'eval' => 'null,' . \FriendsOfTYPO3\TtAddress\Evaluation\LongitudeEvaluation::class,
                'default' => null,
                'fieldControl' => [
                    'locationMap' => [
                        'renderType' => 'locationMapWizard'
                    ]
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'address' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_place.address',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tt_address',
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
    ],
];
