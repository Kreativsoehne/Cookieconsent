<?php

$GLOBALS['TL_DCA']['tl_ks_cc_category'] = [
    'config' => [
        'dataContainer' => 'Table',
        'ctable' => ['tl_ks_cc_category_language'],
        'enableVersioning' => true,
        'notSortable' => false,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'alias' => 'index',
            ],
        ],
    ],
    'list' => [
		'sorting' => [
			'mode' => 5,
			'fields' => ['sorting', 'id'],
            'flag' => 11,
            'headerFields' => ['alias'],
            'disableGrouping' => true,
			'panelLayout' => 'filter;search,limit',
            'child_record_callback' => ['Kreativsoehne\Cookieconsent\Backend\Category', 'listLanguageRows'],
            'paste_button_callback' => ['Kreativsoehne\Cookieconsent\Backend\Category', 'pasteItem'],
        ],
		'label' => [
			'fields' => ['alias'],
			'format' => "%s",
        ],
		'global_operations' => [
			'all' => [
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            ]
        ],
        'operations' => [
            'edit' => [
                'label'               => ['LB edit', 'Help'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ],
            'copy' => [
                'label'               => ['LB copy', 'Help'],
                'href'                => 'act=paste&amp;mode=copy',
                'icon'                => 'copy.gif'
            ],
            'cut' => [
                'label'               => ['LB Cut', 'Help'],
                'href'                => 'act=paste&amp;mode=cut',
                'icon'                => 'cut.svg',
                'attributes'          => 'onclick="Backend.getScrollOffset()"',
                // 'button_callback'     => array('Kreativsoehne\Cookieconsent\Backend\Category', 'disableAction')
            ],
            'delete' => [
                'label'               => ['LB delete', 'Help'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ],
            // 'toggle' => [
            //     'label'               => ['LB toggle', 'Help'],
            //     'icon'                => 'visible.gif',
            //     'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
            //     'button_callback'     => ['Kreativsoehne\Cookieconsent\Backend\Category', 'toggleIcon']
            // ],
            'show' => [
                'label'               => ['LB show', 'Help'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            ],
        ]
    ],
	'palettes' => [
        'default' => '{general_legend},alias,needed,wanted,checked;{languages_legend},languages;published',
    ],
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default 0"
        ],
        'sorting' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'pid' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
		'alias' => [
			'label' => ['LB Alias', 'Help'],
			'exclude' => true,
			'inputType' => 'text',
			'search' => true,
			'eval' => ['mandatory'=>true, 'rgxp'=>'folderalias', 'doNotCopy'=>true, 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50'],
			'sql' => "varchar(128) NOT NULL default ''"
        ],
        'needed' => [
            'label' => ['LB Needed', 'Help'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['doNotCopy'=>true, 'tl_class' => 'w50'],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'wanted' => [
            'label' => ['LB Wanted', 'Help'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['doNotCopy'=>true, 'tl_class' => 'w50'],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'checked' => [
            'label' => ['LB Checked', 'Help'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['doNotCopy'=>true, 'tl_class' => 'w50'],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'languages' => [
            'label' => ['LB Language', 'Help'],
            'inputType' => 'dcaWizard',
            'foreignTable' => 'tl_ks_cc_category_language',
            'eval' => [
                'listCallback' => ['Kreativsoehne\Cookieconsent\Backend\Category', 'generateLanguageWizardList'],
                'editButtonLabel' => 'LB Edit Languages',
                'applyButtonLabel' => 'LB Close',
                'tl_class' =>'clr'
            ]
        ],
        'published' => [
            'label' => ['LB Published', 'Help'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['doNotCopy'=>true],
            'sql' => "char(1) NOT NULL default ''",
        ]
    ]
];
