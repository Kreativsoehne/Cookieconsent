<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2020 Kreativ&Söhne GmbH

 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

/**
 * Extend the palettes.
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'cookieconsent_enable';
$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] .= ';{cookieconsent_legend},cookieconsent_enable';
if (isset($GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'])) {
    $GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'] .= ';{cookieconsent_legend},cookieconsent_enable';
}

$GLOBALS['TL_DCA']['tl_page']['subpalettes']['cookieconsent_enable'] = 'cookieconsent_heading,cookieconsent_privacy_link,cookieconsent_cookie_link,cookieconsent_message,cookieconsent_settings_message,cookieconsent_info_necessary,cookieconsent_info_analytics,cookieconsent_info_recommendations,cookieconsent_info_advertisement,cookieconsent_info_measurements,cookieconsent_info_external';

/*
 * Add the fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_enable'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_enable'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['submitOnChange' => true, 'tl_class' => 'clr'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_privacy_link'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_privacy_link'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'dcaPicker' => true, 'fieldType' => 'radio', 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_cookie_link'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_cookie_link'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'dcaPicker' => true, 'fieldType' => 'radio', 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_heading'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_heading'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => false, 'tl_class' => ''],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_message'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_message'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'tl_class' => 'long clr', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_settings_message'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_settings_message'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'tl_class' => 'long clr', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_info_necessary'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_info_necessary'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'tl_class' => 'long', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_info_analytics'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_info_analytics'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'tl_class' => 'long', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_info_recommendations'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_info_recommendations'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'tl_class' => 'long', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_info_advertisement'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_info_advertisement'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'tl_class' => 'long', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_info_measurements'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_info_measurements'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'tl_class' => 'long', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_info_external'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_info_external'],
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => ['mandatory' => false, 'tl_class' => 'long', 'rte' => 'tinyMCE'],
    'sql' => 'text NULL',
];
