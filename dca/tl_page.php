<?php

/**
 * Extend the palettes.
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'cookiecsonent_enable';
$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] .= ';{cookieconsent_legend},cookieconsent_enable';
if (isset($GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'])) {
    $GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'] .= ';{cookieconsent_legend},cookieconsent_enable';
}

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
