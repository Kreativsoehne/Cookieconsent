<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2021 Kreativ&Söhne GmbH

 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

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
				'href' => 'act=select',
				'class' => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            ]
        ],
        'operations' => [
            'edit' => [
                'href' => 'act=edit',
                'icon' => 'edit.gif'
            ],
            'copy' => [
                'href' => 'act=paste&amp;mode=copy',
                'icon' => 'copy.gif'
            ],
            'cut' => [
                'href' => 'act=paste&amp;mode=cut',
                'icon' => 'cut.svg',
                'attributes' => 'onclick="Backend.getScrollOffset()"',
                // 'button_callback'     => array('Kreativsoehne\Cookieconsent\Backend\Category', 'disableAction') // Do we need this at all?
            ],
            'delete' => [
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ],
            'toggle' => [
                'icon' => 'visible.gif',
                'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => ['Kreativsoehne\Cookieconsent\Backend\Category', 'toggleIcon']
            ],
            'show' => [
                'href' => 'act=show',
                'icon' => 'show.gif'
            ],
        ]
    ],
	'palettes' => [
        'default' => '{general_legend},alias,needed,wanted,checked;languages;published',
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
			'label' => $GLOBALS['TL_LANG']['tl_ks_cc_common']['ALIAS'],
			'exclude' => true,
			'inputType' => 'text',
			'search' => true,
			'eval' => ['mandatory'=>true, 'rgxp'=>'folderalias', 'doNotCopy'=>true, 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50'],
			'sql' => "varchar(128) NOT NULL default ''"
        ],
        'needed' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_category']['NEEDED'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['doNotCopy'=>true, 'tl_class' => 'w50'],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'wanted' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_category']['WANTED'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['doNotCopy'=>true, 'tl_class' => 'w50'],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'checked' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_category']['CHECKED'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['doNotCopy'=>true, 'tl_class' => 'w50'],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'languages' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_common']['LANGUAGES'],
            'inputType' => 'dcaWizard',
            'foreignTable' => 'tl_ks_cc_category_language',
            'eval' => [
                'listCallback' => ['Kreativsoehne\Cookieconsent\Backend\Category', 'generateLanguageWizardList'],
                'editButtonLabel' => $GLOBALS['TL_LANG']['tl_ks_cc_common']['EDIT_LANGUAGES'],
                'applyButtonLabel' => $GLOBALS['TL_LANG']['MSC']['close'],
                'tl_class' =>'clr'
            ]
        ],
        'published' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_common']['PUBLISHED'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => ['doNotCopy'=>true],
            'sql' => "char(1) NOT NULL default ''",
        ]
    ]
];
