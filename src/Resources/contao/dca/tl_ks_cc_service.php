<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2021 Kreativ&Söhne GmbH

 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

$GLOBALS['TL_DCA']['tl_ks_cc_service'] = [
    'config' => [
        'dataContainer' => 'Table',
        'ctable' => ['tl_ks_cc_service_language'],
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
            'child_record_callback' => ['Kreativsoehne\Cookieconsent\Backend\Service', 'listLanguageRows'],
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
                // 'button_callback' => array('Kreativsoehne\Cookieconsent\Backend\Service', 'disableAction') // Do we need this at all?
            ],
            'delete' => [
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ],
            'toggle' => [
                'icon' => 'visible.gif',
                'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => ['Kreativsoehne\Cookieconsent\Backend\Service', 'toggleIcon']
            ],
            'show' => array
            (
                'href' => 'act=show',
                'icon' => 'show.gif'
            )
        ]
    ],
	'palettes' => [
        'default' => '{general_legend},alias,category,type,duration,cookies,keywords;languages;published',
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
		'category' => [
			'label' => $GLOBALS['TL_LANG']['tl_ks_cc_service']['CATEGORY'],
			'exclude' => true,
            'filter' => true,
			'inputType' => 'select',
            'foreignKey' => 'tl_ks_cc_category.alias',
			'search' => true,
            'eval' => ['mandatory' => true, 'tl_class' => '', 'maxlength'=>128, 'tl_class'=>'w50'],
            'sql' => "varchar(128) NOT NULL default ''"
        ],
        'type' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_service']['TYPE'],
            'exclude' => true,
            'inputType' => 'select',
            'default' => 'localcookie',
            'options' => [
                'dynamic-script' => $GLOBALS['TL_LANG']['tl_ks_cc_service']['TYPE_DYNAMIC'],
                'localcookie' => $GLOBALS['TL_LANG']['tl_ks_cc_service']['TYPE_LOCAL'],
                'script-tag' => $GLOBALS['TL_LANG']['tl_ks_cc_service']['TYPE_TAG'],
                // 'wrapped' => $GLOBALS['TL_LANG']['tl_ks_cc_service']['TYPE_WRAPPED'] // Currently not supported
            ],
            'eval' => ['mandatory' => true, 'tl_class' => '', 'maxlength'=>128, 'tl_class'=>'w50'],
            'sql' => "varchar(128) NOT NULL default ''"
        ],
        'cookies' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_service']['COOKIES'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => false, 'tl_class' => '', 'maxlength'=>255, 'tl_class'=>'w50'],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'keywords' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_service']['KEYWORDS'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => false, 'tl_class' => '', 'maxlength'=>255, 'tl_class'=>'w50'],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'duration' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_service']['DURATION'],
            'exclude' => true,
            'inputType' => 'select',
            'default' => 'session',
            'options' => $GLOBALS['TL_LANG']['tl_ks_cc_service']['duration'],
            'eval' => ['mandatory' => false, 'tl_class' => '', 'maxlength'=>128, 'tl_class'=>'w50'],
            'sql' => "varchar(128) NOT NULL default ''"
        ],
        'languages' => [
            'label' => $GLOBALS['TL_LANG']['tl_ks_cc_common']['LANGUAGES'],
            'inputType' => 'dcaWizard',
            'foreignTable' => 'tl_ks_cc_service_language',
            'eval' => [
                'listCallback' => ['Kreativsoehne\Cookieconsent\Backend\Service', 'generateLanguageWizardList'],
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
