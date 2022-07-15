<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2022 Kreativ&Söhne GmbH

 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

namespace Kreativsoehne\Cookieconsent\Backend;

/**
 * Service
 */
class Service extends AbstractBackend
{
    /**
     * @inheritDoc
     */
    protected $strTable = 'tl_ks_cc_service';

    /**
     * @inheritDoc
     */
    protected $sLanguageTable = 'tl_ks_cc_service_language';
}
