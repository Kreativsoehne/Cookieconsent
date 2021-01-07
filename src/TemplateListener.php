<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2020 Kreativ&Söhne GmbH

 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

namespace Kreativsoehne\Cookieconsent;

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
            $template->blocknotice = $this->getSubTemplateContent('cookieconsent_blocknotice');
            $template->categories = $this->getSubTemplateContent('cookieconsent_categories');
            $template->languagesettings = $this->getSubTemplateContent('cookieconsent_language');
            $template->services = $this->getSubTemplateContent('cookieconsent_services');

            $result = $template->parse();
            $buffer = str_replace('</body>', $result . '</body>', $buffer);

            \Contao\Config::set('debugMode', $blDebugMode);
        }

        return $buffer;
    }

    /**
     * Get root data
     * @param \Contao\FrontendTemplate $template
     * @param \Contao\PageModel $rootPage
     * @return array
     */
    protected function setData($template) {
        foreach ($this->rootData as $key => $value) {
            $template->{$key} = $value;
        }

        return $template;
    }

    /**
     * Get child template content
     * @param string $name
     * @return \Contao\FrontendTemplate
     */
    protected function getSubTemplateContent($template, $trimNewlines = true) {
        $template = new \Contao\FrontendTemplate($template);
        $template = $this->setData($template);
        $result = $template->parse();
        if ($trimNewlines === true) {
            $result = $this->trimNewslines($result);
        }

        return $result;
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
