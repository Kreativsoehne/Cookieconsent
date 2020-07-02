<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2020 Kreativ&Söhne GmbH

 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = [Kreativsoehne\Cookieconsent\TemplateListener::class, 'onOutputFrontendTemplate'];
