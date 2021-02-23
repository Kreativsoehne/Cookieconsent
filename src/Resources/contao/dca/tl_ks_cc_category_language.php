<?php

$GLOBALS['TL_DCA']['tl_ks_cc_category_language'] = [
    'config' => [
        'dataContainer' => 'Table',
        'ptable' => 'tl_ks_cc_category',
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
            'format' => '%s <span style="color:#b3b3b3; padding-left:3px;">[%s]</span>',
        ],
        'operations' => [
            'edit' => [
                'label'               => ['LB Edit', 'Help'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ],
            'copy' => [
                'label'               => ['LB Copy', 'Help'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ],
            'delete' => [
                'label'               => ['LB Delete', 'Help'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ],
            'show' => [
                'label'               => ['LB Show', 'Help'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            ]
        ]
    ],
	'palettes' => [
        'default' => '{general_legend},language;{content_legend},name,description',
    ],
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default 0"
        ],
        'pid' => [
            'foreignKey'              => 'tl_ks_cc_category.alias',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => ['type'=>'belongsTo', 'load'=>'lazy']
        ],
        'language' => [
            'label' => ['LB Language', 'Help'],
            'exclude' => true,
            'default' => $GLOBALS['TL_LANGUAGE'],
            'inputType' => 'select',
            'options' => \System::getLanguages(),
            'eval' => ['mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'],
            'sql' => "varchar(5) NOT NULL default ''",
            // 'save_callback' => ['Kreativsoehne\Cookieconsent\Backend\Category', 'validateLanguageField'],
        ],
		'name' => [
            'label' => ['LB Name', 'Help'],
            'exclude' => true,
            'inputType' => 'textarea',
            'eval' => ['mandatory' => true, 'tl_class'=>'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
		'description' => [
            'label' => ['LB Description', 'Help'],
            'exclude' => true,
            'inputType' => 'textarea',
            'eval' => ['mandatory' => true, 'tl_class' => 'long clr', 'rte' => 'tinyMCE'],
            'sql' => 'text NULL',
        ],
    ]
];
