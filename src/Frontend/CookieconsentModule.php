<?php

/**
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2022 Kreativ&Söhne GmbH
 *
 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

namespace Kreativsoehne\Cookieconsent\Frontend;

use Contao\Module;
use Kreativsoehne\Cookieconsent\Model\Category;
use Kreativsoehne\Cookieconsent\Model\CategoryLanguage;
use Kreativsoehne\Cookieconsent\Model\Service;
use Kreativsoehne\Cookieconsent\Model\ServiceLanguage;

/**
 * @todo Implement as actual FrontendModuleController, didn't work yet though
 */
class CookieconsentModule extends \Contao\Module
{
    /** @var string */
    public const TYPE = 'kreativsoehne_cookieconsent';

    /**
     * @inheritDoc
     */
    protected $strTemplate = 'mod_ks_cookieconsent';

    /** @var mixed[] */
    protected $rootData = [];

    /**
     * @inheritDoc
     */
    protected function compile()
    {
        if (TL_MODE === 'BE') {
            $this->compileForBackend();
        } else {
            $this->compileForFrontend();
        }
    }

    /**
     * Compile for backend view
     */
    protected function compileForBackend()
    {
        $this->strTemplate = 'be_wildcard';
        $this->Template = new BackendTemplate($this->strTemplate);
        $this->Template->title = $GLOBALS['TL_LANG']['FMD'][self::TYPE][0];
    }

    /**
     * Compile for frontend view
     */
    protected function compileForFrontend()
    {
        $blDebugMode = \Contao\Config::get('debugMode');
        \Contao\Config::set('debugMode', false);

        $this->prepareRotData();
        $this->setTemplateData($this->Template, $this->rootData);

        $categories = $this->getCategories();
        $services = $this->getServices();

        $this->Template->barTimeout = $this->isImprintOrPrivacyPage() === true ? 3600000 : 0; // 1h
        $this->Template->blocknotice = $this->renderTemplate('cookieconsent_blocknotice', $this->rootData);
        $this->Template->categories = $this->getCategoriesContent($categories);
        $this->Template->languagesettings = $this->renderTemplate('cookieconsent_language', $this->rootData);
        $this->Template->services = $this->getServicesContent($services, $categories);

        \Contao\Config::set('debugMode', $blDebugMode);
    }

    /**
     * Readout and prepare root data
     */
    protected function prepareRotData()
    {
        foreach ($this->arrData as $key => $value) {
            if (strpos($key, 'ks_cc_') === 0) {
                $this->rootData[substr($key, strlen('ks_cc_'))] = $value;
            }
        }

        $this->rootData['heading'] = '<div class="h4 ccb__heading">' . html_entity_decode($this->rootData['heading']) . '</div>';
    }

    /**
     * Getter available categories with category ID as key
     * @return Category[]
     */
    protected function getCategories(): array
    {
        $result = [];

        $availableCategories = Category::findBy(['published = ?'], [1], ['order' => 'sorting ASC']);
        foreach ($availableCategories as $id => $category) {
            $result[$category->id] = $category;
        }

        return $result;
    }

    /**
     * Get categories
     * @param Category[] $categories
     * @return string
     */
    protected function getCategoriesContent(array $categories): string
    {
        if (true === empty($categories)) {
            return '';
        }

        foreach ($categories as $category) {
            $languages = CategoryLanguage::findByPid($category->id);
            if (count($languages) > 0) {
                $category->languages = $languages;
            }
        }

        return $this->renderTemplate('cookieconsent_categories', ['categories' => $categories]);
    }

    /**
     * Getter available services with service ID as key
     * @return Service[]
     */
    protected function getServices(): array
    {
        $result = [];

        $availableServices = Service::findBy(['published = ?'], [1], ['order' => 'sorting ASC']);
        foreach ($availableServices as $id => $service) {
            $result[$service->id] = $service;
        }

        return $result;
    }



    /**
     * Get services content
     * @param Service[] $services
     * @param Category[] $categories
     * @return string
     */
    protected function getServicesContent(array $services, array $categories): string
    {
        if (true === empty($services)) {
            return '';
        }

        $renderableServices = [];

        foreach ($services as $service) {
            $category = isset($categories[$service->category]) === true ? $categories[$service->category] : null;
            $languages = ServiceLanguage::findByPid($service->id);

            // Nothing to do without category or languages
            if (!$category instanceof Category || empty($languages) === true) {
                continue;
            }

            // We need the proper alias, not the ID of the category
            $service->category = $category->alias;

            $service->languages = $languages;

            if (gettype($service->cookies) === 'string') {
                $service->cookies = empty(trim($service->cookies)) === false ? explode(',', $service->cookies) : [];
            }

            if (gettype($service->keywords) === 'string') {
                $service->keywords = empty(trim($service->keywords)) === false ? explode(',', $service->keywords) : [];
            }

            $renderableServices[] = $service;
        }

        return $this->renderTemplate('cookieconsent_services', ['services' => $renderableServices]);
    }

    /**
     * Check if current page is imprint or privacy page
     * @return bool
     */
    protected function isImprintOrPrivacyPage(): bool
    {
        $currentPageId = $GLOBALS['objPage']->id;
        $currentPageUrl = null;

        /** @note Contao 4.13 (and above): Pages with requireItem can not get urls generated without parameters */
        if (
            null === $GLOBALS['objPage']->requireItem ||
            true === empty($GLOBALS['objPage']->requireItem)
        ) {
            $currentPageUrl = $GLOBALS['objPage']->getFrontendUrl();
        }

        $imprintLink = $this->rootData['cookie_link'];
        $privacyLink = $this->rootData['privacy_link'];

        preg_match('/^{{link_url::(\d+)/', $imprintLink, $imprintMatches);
        $imprintPageId = count($imprintMatches) > 1 ? $imprintMatches[1] : null;

        preg_match('/^{{link_url::(\d+)/', $privacyLink, $privacyMatches);
        $privacyPageId = count($privacyMatches) > 1 ? $privacyMatches[1] : null;

        return (
            $currentPageId === $imprintPageId ||
            $currentPageId === $privacyPageId ||
            $currentPageUrl === $imprintLink ||
            $currentPageUrl === $privacyLink
        );
    }

    /**
     * Render child template with specified data
     * @param string $template
     * @param array $data
     * @return string
     */
    protected function renderTemplate(string $template, array $data): string
    {
        $template = new \Contao\FrontendTemplate($template);
        $this->setTemplateData($template, $data);

        $result = $template->parse();
        return preg_replace('/\r|\n/', '', $result);
    }

    /**
     * Set data into template
     * @param \Contao\FrontendTemplate $template
     * @param array $data
     */
    protected function setTemplateData(\Contao\FrontendTemplate $template, array $data)
    {
        foreach ($data as $key => $value) {
            $template->{$key} = $value;
        }
    }
}
