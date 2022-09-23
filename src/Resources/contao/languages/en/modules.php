<?php

/**
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2022 Kreativ&Söhne GmbH
 *
 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

use Kreativsoehne\Cookieconsent\Controller\FrontendModule\CookieconsentController;

$GLOBALS['TL_LANG']['FMD'][CookieconsentController::TYPE] = [
    'Cookieconsent',
    'Renders Cookieconsent',
];

$GLOBALS['TL_LANG']['MOD']['kreativsoehne_cookieconsent'] = ['Cookieconsent', 'Manage cookieconsent'];
$GLOBALS['TL_LANG']['MOD']['kreativsoehne_cookieconsent_category'] = ['Categories', 'Cookieconsent categories'];
$GLOBALS['TL_LANG']['MOD']['kreativsoehne_cookieconsent_service'] = ['Services / Cookies', 'Cookieconsent Services / Cookies'];

$GLOBALS['TL_LANG']['tl_ks_cc_common']['general_legend'] = 'General';
$GLOBALS['TL_LANG']['tl_ks_cc_common']['ALIAS'] = ['Alias', ''];
$GLOBALS['TL_LANG']['tl_ks_cc_common']['DESCRIPTION'] = ['Description', ''];
$GLOBALS['TL_LANG']['tl_ks_cc_common']['EDIT_LANGUAGES'] = 'Edit language';
$GLOBALS['TL_LANG']['tl_ks_cc_common']['LANGUAGES'] = ['Language entries', 'List of data and texts translated in required languages'];
$GLOBALS['TL_LANG']['tl_ks_cc_common']['LANGUAGE'] = ['Language', ''];
$GLOBALS['TL_LANG']['tl_ks_cc_common']['NAME'] = ['Name', ''];
$GLOBALS['TL_LANG']['tl_ks_cc_common']['PUBLISHED'] = ['Publish', ''];
