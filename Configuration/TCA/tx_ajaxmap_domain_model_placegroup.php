<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}
$ll = 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:';
$cll = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:';

return [
    'ctrl' => [
        'title'	=> $ll . 'tx_ajaxmap_domain_model_placegroup',
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
        'sortby' => 'sorting',
        'typeicon_classes' => [
            'default' => \DWenzel\Ajaxmap\Configuration\SettingsInterface::ICON_IDENTIFIER_PLACEGROUP
        ]
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid,--palette--,l10n_parent,l10n_diffsource,hidden,--palette--;;1,title,description,icon,parent,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime,endtime'],
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
                'foreign_table' => 'tx_ajaxmap_domain_model_placegroup',
                'foreign_table_where' => 'AND tx_ajaxmap_domain_model_placegroup.pid=###CURRENT_PID### AND tx_ajaxmap_domain_model_placegroup.sys_language_uid IN (-1,0)',
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
            'label' => $ll . 'tx_ajaxmap_domain_model_placegroup.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true
            ],
        ],
        'description' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_placegroup.description',
            'config' => [
                'type' => 'text',
                'cols' => 32,
                'rows' => 3,
                'eval' => 'trim'
            ],
        ],
        'icon' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_placegroup.icon',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('icon', ['uploadfolder' => 'uploads/tx_ajaxmap'], $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']),
        ],
        'parent' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_placegroup.parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'foreign_table' => 'tx_ajaxmap_domain_model_placegroup',
                'foreign_table_where' => ' AND tx_ajaxmap_domain_model_placegroup.sys_language_uid IN (-1,0) ORDER BY tx_ajaxmap_domain_model_placegroup.sorting ASC',
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
                'renderMode' => 'tree',
                'treeConfig' => [
                    'appearance' => [
                        'expandAll' => 1,
                        'maxLevels' => 99,
                        'showHeader' => 1
                    ],
                    'parentField' => 'parent',
                ],
                'fieldControl' => [
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
    ],
];
