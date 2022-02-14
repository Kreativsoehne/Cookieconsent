<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2021 Kreativ&Söhne GmbH

 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

namespace Kreativsoehne\Cookieconsent;

use Kreativsoehne\Cookieconsent\Model\Category;
use Kreativsoehne\Cookieconsent\Model\CategoryLanguage;
use Kreativsoehne\Cookieconsent\Model\Service;
use Kreativsoehne\Cookieconsent\Model\ServiceLanguage;

/**
 * TemplateListener
 */
class TemplateListener
{
    /**
     * Data from root page
     * @var array
     */
    protected $rootData = [];

    /**
     * Output cookieconsent on frontend template if enabled
     * @param string $buffer
     * @return string
     */
    public function onOutputFrontendTemplate($buffer)
    {
        $rootPage = \Contao\PageModel::findByPk($GLOBALS['objPage']->rootId);
        $rootData = $rootPage->row();

        foreach ($rootData as $key => $value) {
            if (strpos($key, 'cookieconsent_') === 0) {
                $this->rootData[substr($key, strlen('cookieconsent_'))] = $value;
            }
        }

        if (empty($this->rootData['heading']) === false) {
            $this->rootData['heading'] = '<div class="h4 ccb__heading">' . html_entity_decode($this->rootData['heading']) . '</div>';
        }

        if ($rootPage !== null && empty($this->rootData['enable']) === false) {
            // Temporarily disable debug-mode to prevent template-hints within javascript-code
            $blDebugMode = \Contao\Config::get('debugMode');
            \Contao\Config::set('debugMode', false);

            $template = new \Contao\FrontendTemplate('cookieconsent');
            $template = $this->setData($template);

            $categories = $this->getCategories();
            $services = $this->getServices();
            $template->blocknotice = $this->renderTemplate('cookieconsent_blocknotice');
            $template->categories = $this->getCategoriesContent($categories);
            $template->languagesettings = $this->renderTemplate('cookieconsent_language');
            $template->services = $this->getServicesContent($services, $categories);

            $result = $template->parse();
            $buffer = str_replace('</body>', $result . '</body>', $buffer);

            \Contao\Config::set('debugMode', $blDebugMode);
        }

        return $buffer;
    }

    /**
     * Get categories
     * @param array $categories
     * @return string
     */
    protected function getCategoriesContent(array $categories): string
    {
        if (count($categories) < 1) {
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
     * Get services content
     * @param array $categories
     * @return string
     */
    protected function getServicesContent(array $services, array $categories): string
    {
        if (count($services) < 1) {
            return '';
        }

        foreach ($services as $service) {
            $languages = ServiceLanguage::findByPid($service->id);

            if (count($languages) > 0) {
                $service->languages = $languages;

                if (gettype($service->cookies) === 'string') {
                    $service->cookies = empty(trim($service->cookies)) === false ? explode(',', $service->cookies) : [];
                }
                if (gettype($service->keywords) === 'string') {
                    $service->keywords = empty(trim($service->keywords)) === false ? explode(',', $service->keywords) : [];
                }

                $category = $categories[$service->category];
                if (empty($category) === false) {
                    $service->category = $category->alias;
                }
            }
        }

        return $this->renderTemplate('cookieconsent_services', ['services' => $services]);
    }

    /**
     * Getter available categories with category ID as key
     * @return [Category]
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
     * Getter available services with service ID as key
     * @return [Service]
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
     * Get child template content
     * @param string $name
     * @return \Contao\FrontendTemplate
     */
    protected function renderTemplate($template, $data = null, $trimNewlines = true)
    {
        $template = new \Contao\FrontendTemplate($template);
        $template = $this->setData($template, $data);
        $result = $template->parse();
        if ($trimNewlines === true) {
            $result = $this->trimNewslines($result);
        }

        return $result;
    }

    /**
     * Get root data
     * @param \Contao\FrontendTemplate $template
     * @param \Contao\PageModel $rootPage
     * @return array
     */
    protected function setData($template, $data = null)
    {
        if ($data === null) {
            $data = $this->rootData;
        }

        foreach ($data as $key => $value) {
            $template->{$key} = $value;
        }

        return $template;
    }

    /**
     * Basic method to trim newlines
     *
     * @param string $value
     * @return stringd
     */
    protected function trimNewslines(string $value)
    {
        return preg_replace('/\r|\n/', '', $value);
    }
}
