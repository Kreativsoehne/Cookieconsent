<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2021 Kreativ&Söhne GmbH

 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

// Add cookieconsent to frontend output, if enabled
$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = [Kreativsoehne\Cookieconsent\TemplateListener::class, 'onOutputFrontendTemplate'];

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
