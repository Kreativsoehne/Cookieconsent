<?php
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
