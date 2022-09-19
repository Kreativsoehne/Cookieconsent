<?php

/**
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2022 Kreativ&Söhne GmbH
 *
 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

use Kreativsoehne\Cookieconsent\Frontend\CookieconsentModule;
use Kreativsoehne\Cookieconsent\Content\ToggleContentElement;

$GLOBALS['BE_MOD']['kreativsoehne_cookieconsent']['kreativsoehne_cookieconsent_category'] = [
    'tables' => ['tl_ks_cc_category', 'tl_ks_cc_category_language'],
];
$GLOBALS['TL_MODELS']['tl_ks_cc_category'] = 'Kreativsoehne\Cookieconsent\Model\Category';
$GLOBALS['TL_MODELS']['tl_ks_cc_category_language'] = 'Kreativsoehne\Cookieconsent\Model\CategoryLanguage';

// Services/Cookies
$GLOBALS['BE_MOD']['kreativsoehne_cookieconsent']['kreativsoehne_cookieconsent_service'] = [
    'tables' => ['tl_ks_cc_service', 'tl_ks_cc_service_language'],
];
$GLOBALS['TL_MODELS']['tl_ks_cc_service'] = 'Kreativsoehne\Cookieconsent\Model\Service';
$GLOBALS['TL_MODELS']['tl_ks_cc_service_language'] = 'Kreativsoehne\Cookieconsent\Model\ServiceLanguage';

if (TL_MODE === 'BE') {
    $GLOBALS['TL_CSS'][] = 'bundles/kreativsoehnecookieconsent/backend/cookieconsent.css';
}

$GLOBALS['TL_CTE']['miscellaneous']['cookieconsent_toggle'] = ToggleContentElement::class;

// No clue why the @FrontendModule doesn't work
$GLOBALS['FE_MOD']['miscellaneous'][CookieconsentModule::TYPE] = CookieconsentModule::class;
