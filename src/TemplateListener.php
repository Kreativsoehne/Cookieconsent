<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2021 Kreativ&Söhne GmbH

 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

namespace Kreativsoehne\Cookieconsent;

use \Kreativsoehne\Cookieconsent\Model\Category;
use \Kreativsoehne\Cookieconsent\Model\CategoryLanguage;
use \Kreativsoehne\Cookieconsent\Model\Service;
use \Kreativsoehne\Cookieconsent\Model\ServiceLanguage;

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

            $template->blocknotice = $this->renderTemplate('cookieconsent_blocknotice');
            $template->categories = $this->getCategoriesContent();
            $template->languagesettings = $this->renderTemplate('cookieconsent_language');
            $template->services = $this->getServicesContent();

            $result = $template->parse();
            $buffer = str_replace('</body>', $result . '</body>', $buffer);

            \Contao\Config::set('debugMode', $blDebugMode);
        }

        return $buffer;
    }

    /**
     * Get categories
     *
     * @return string
     */
    protected function getCategoriesContent() {
        $availableCategories = Category::findBy(['published = ?'], [1], ['order' => 'sorting ASC']);
        $categories = [];

        if (count($availableCategories) < 1) {
            return '';
        }

        foreach ($availableCategories as $category) {
            $languages = CategoryLanguage::findByPid($category->id);
            if (count($languages) > 0) {
                $category->languages = $languages;
                $categories[] = $category;
            }
        }

        return $this->renderTemplate('cookieconsent_categories', ['categories' => $categories]);
    }

    /**
     * Get services content
     *
     * @return string
     */
    protected function getServicesContent() {
        $availableServices = Service::findBy(['published = ?'], [1], ['order' => 'sorting ASC']);
        $services = [];

        if (count($availableServices) < 1) {
            return '';
        }

        foreach ($availableServices as $service) {
            $languages = ServiceLanguage::findByPid($service->id);
            if (count($languages) > 0) {
                $service->languages = $languages;
                $service->cookies = empty(trim($service->cookies)) === false ? explode(',', $service->cookies) : [];
                $service->category = Category::findBy(['id = ?', 'published = ?'], [$service->category, 1]);
                $service->keywords = empty(trim($service->keywords)) === false ?explode(',', $service->keywords) : [];
                $services[] = $service;
            }
        }

        return $this->renderTemplate('cookieconsent_services', ['services' => $services]);
    }

    /**
     * Get child template content
     * @param string $name
     * @return \Contao\FrontendTemplate
     */
    protected function renderTemplate($template, $data = null, $trimNewlines = true) {
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
    protected function setData($template, $data = null) {
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
    protected function trimNewslines(string $value) {
        return preg_replace('/\r|\n/', '', $value);
    }
}
