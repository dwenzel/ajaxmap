<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
$ll = 'LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:';
$cll = 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:';

return [
    'ctrl' => [
        'title'	=> $ll . 'tx_ajaxmap_domain_model_placegroup',
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
        'sortby' => 'sorting',
        'iconfile' => 'EXT:ajaxmap/Resources/Public/Icons/tx_ajaxmap_domain_model_placegroup.gif'

    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, icon, parent',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, description, icon, parent,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'],
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
            'label' => $ll . 'tx_ajaxmap_domain_model_placegroup.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
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
            'config' => [
                'type' => 'group',
                'internal_type' => 'file_reference',
                'show_thumbs' => 1,
                'size' => 1,
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'uploadfolder' => 'uploads/tx_ajaxmap',
                'disallowed' => '',
            ],
        ],
        'parent' => [
            'exclude' => 0,
            'label' => $ll . 'tx_ajaxmap_domain_model_placegroup.parent',
            'config' => [
                'type' => 'select',
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
                'wizards' => [
                    '_PADDING' => 1,
                    '_VERTICAL' => 1,
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
                    'suggest' => [
                        'type' => 'suggest',
                    ],
                ],
            ],
        ],
    ],
];
