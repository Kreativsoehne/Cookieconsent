<?php

/**
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2022 Kreativ&Söhne GmbH
 *
 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

use Kreativsoehne\Cookieconsent\Controller\FrontendModule\CookieconsentController;

$GLOBALS['TL_DCA']['tl_module']['palettes'][CookieconsentController::TYPE] =
    '{title_legend},name,type;{ks_cc_legend},ks_cc_heading,ks_cc_privacy_link,ks_cc_cookie_link,ks_cc_message,ks_cc_settings_message';

$GLOBALS['TL_DCA']['tl_module']['fields']['ks_cc_privacy_link'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['ks_cc_privacy_link'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'dcaPicker' => true, 'fieldType' => 'radio', 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['ks_cc_cookie_link'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['ks_cc_cookie_link'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'dcaPicker' => true, 'fieldType' => 'radio', 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['ks_cc_heading'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['ks_cc_heading'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => false, 'tl_class' => ''],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['ks_cc_message'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['ks_cc_message'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'tl_class' => 'long clr', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['ks_cc_settings_message'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['ks_cc_settings_message'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'tl_class' => 'long clr', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];
