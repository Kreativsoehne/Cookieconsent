<?php

$GLOBALS['TL_DCA']['tl_ks_cc_service_language'] = [
    'config' => [
        'dataContainer' => 'Table',
        'ptable' => 'tl_ks_cc_service',
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'pid' => 'index',
                'language' => 'index'
            ],
        ],
    ],
    'list' => [
		'sorting' => [
			'mode' => 1,
			'fields' => ['language'],
			'flag' => 1
        ],
        'label' => [
            'fields' => ['language'],
            'format' => '%s',
        ],
        'operations' => [
            'edit' => [
                'href' => 'act=edit',
                'icon' => 'edit.gif'
            ],
            'copy' => [
                'href' => 'act=copy',
                'icon' => 'copy.gif'
            ],
            'delete' => [
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ],
            'show' => [
                'href' => 'act=show',
                'icon' => 'show.gif'
            ]
        ]
    ],
	'palettes' => [
        'default' => '{general_legend},language,name,description',
    ],
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default 0"
        ],
        'pid' => [
            'foreignKey'              => 'tl_ks_cc_service.alias',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => ['type'=>'belongsTo', 'load'=>'lazy']
        ],
        'language' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_common']['LANGUAGE'],
            'exclude' => true,
            'default' => $GLOBALS['TL_LANGUAGE'],
            'inputType' => 'select',
            'options' => \System::getLanguages(),
            'eval' => ['mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'],
            'sql' => "varchar(5) NOT NULL default ''",
            // 'save_callback' => ['Kreativsoehne\Cookieconsent\Backend\Service', 'validateLanguageField'],  // Doesn't appear to be called
        ],
		'name' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_common']['NAME'],
            'exclude' => true,
            'inputType' => 'textarea',
            'eval' => ['mandatory' => true, 'tl_class'=>'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
		'description' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_common']['DESCRIPTION'],
            'exclude' => true,
            'inputType' => 'textarea',
            'eval' => ['mandatory' => true, 'tl_class' => 'long clr', 'rte' => 'tinyMCE'],
            'sql' => 'text NULL',
        ],
    ]
];
