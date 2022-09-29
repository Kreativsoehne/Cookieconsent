<?php

/**
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2022 Kreativ&Söhne GmbH
 *
 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

use Kreativsoehne\Cookieconsent\Controller\ContentElement\ToogleCookieconsentController;

/**
 * Frontend
 */
$GLOBALS['TL_LANG']['MCS']['cookieconsent_blockcomment'] = '<!-- Template "##templateName##" durch Kreativsoehne\Cookieconsent geblockt, Cookie-Kategorie "##category##" ist vom User nicht erwünscht -->';
$GLOBALS['TL_LANG']['MCS']['cookieconsent_blocknotice'] = 'Leider sind externe Einbindungen ohne entsprechende Cookies Zustimmung nicht verfügbar.';
$GLOBALS['TL_LANG']['MCS']['cookieconsent_blocknotice_allow'] = 'Cookie Einstellungen bearbeiten';
$GLOBALS['TL_LANG']['MCS']['cookieconsent_toggle_label'] = 'Datenschutz&shy;einstellungen';

$GLOBALS['TL_LANG']['MCS']['cookieconsent_duration'] = 'Zeitdauer';

$GLOBALS['TL_LANG']['tl_ks_cc_service']['duration'] = [
    '' => '',
    'session' => 'Session',
    '1min' => '1 Minute',
    '2min' => '2 Minuten',
    '10min' => '10 Minuten',
    '30min' => '30 Minuten',
    '1hr' => '1 Stunde',
    '2hr' => '2 Stunden',
    '12hr' => '12 Stunden',
    '1day' => '1 Tag',
    '2day' => '2 Tage',
    '1week' => '1 Woche',
    '2week' => '2 Wochen',
    '1month' => '1 Monat',
    '2month' => '2 Monate',
    '6month' => '6 Monate',
    '1year' => '1 Jahr',
    '2year' => '2 Jahre',
    '10year' => '10 Jahre',
    'forever' => 'Ewig',
];


/**
 * Backend
 */
$GLOBALS['TL_LANG']['CTE'][ToogleCookieconsentController::TYPE] = [
    "Cookieconsent Umschalter",
    "Umschalter-Button für die Cookieconsent Einstellungen",
];

