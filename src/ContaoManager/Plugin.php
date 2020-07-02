<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2020 Kreativ&Söhne GmbH

 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

namespace Kreativsoehne\Cookieconsent\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\CoreBundle\ContaoCoreBundle;
use Kreativsoehne\Cookieconsent\KreativsoehneCookieconsentBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(KreativsoehneCookieconsentBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
