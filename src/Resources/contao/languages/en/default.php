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
$GLOBALS['TL_LANG']['MCS']['cookieconsent_blocknotice'] = 'Unfortunately external integrations are not available without cookies acceptance.';
$GLOBALS['TL_LANG']['MCS']['cookieconsent_blocknotice_allow'] = 'Edit cookie settings';
$GLOBALS['TL_LANG']['MCS']['cookieconsent_toggle_label'] = 'Privacy settings';

$GLOBALS['TL_LANG']['MCS']['cookieconsent_duration'] = 'Duration';

$GLOBALS['TL_LANG']['tl_ks_cc_service']['duration'] = [
    '' => '',
    'session' => 'Session',
    '1min' => '1 Minute',
    '2min' => '2 Minutes',
    '10min' => '10 Minutes',
    '30min' => '30 Minutes',
    '1hr' => '1 Hour',
    '2hr' => '2 Hours',
    '12hr' => '12 Hours',
    '1day' => '1 Day',
    '2day' => '2 Days',
    '1week' => '1 Week',
    '2week' => '2 Weeks',
    '1month' => '1 Month',
    '2month' => '2 Months',
    '6month' => '6 Months',
    '1year' => '1 Year',
    '2year' => '2 Years',
    '10year' => '10 Years',
    'forever' => 'Forever',
];

/**
 * Backend
 */
$GLOBALS['TL_LANG']['CTE'][ToogleCookieconsentController::TYPE] = [
    "Cookieconsent Toggle",
    "Toggle Button for cookieconsent settings",
];
