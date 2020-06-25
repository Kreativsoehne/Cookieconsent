<?php

/**
 * Extend the palettes.
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'cookieconsent_enable';
$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] .= ';{cookieconsent_legend},cookieconsent_enable';
if (isset($GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'])) {
    $GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'] .= ';{cookieconsent_legend},cookieconsent_enable';
}

$GLOBALS['TL_DCA']['tl_page']['subpalettes']['cookieconsent_enable'] = 'cookieconsent_message,cookieconsent_button_allow,cookieconsent_button_deny,cookieconsent_link_text,cookieconsent_link_href';

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


$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_message'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_message'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'tl_class' => 'long'],
    'sql' => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_button_allow'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_button_allow'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'maxlength' => 128, 'tl_class' => 'w50'],
    'sql' => "varchar(128) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_button_deny'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_button_deny'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'maxlength' => 128, 'tl_class' => 'w50'],
    'sql' => "varchar(128) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_link_text'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_link_text'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'maxlength' => 128, 'tl_class' => 'w50'],
    'sql' => "varchar(128) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_page']['fields']['cookieconsent_link_href'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_page']['cookieconsent_link_href'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['rgxp' => 'url', 'decodeEntities' => true, 'dcaPicker' => true, 'fieldType' => 'radio', 'tl_class' => 'w50 wizard'],
    'sql' => "varchar(255) NOT NULL default ''",
];
