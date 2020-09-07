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
        $this->rootData = $rootPage->row();

        if ($rootPage !== null && empty($rootPage->cookieconsent_enable) === false) {
            $template = new \Contao\FrontendTemplate('cookieconsent');
            $template = $this->setData($template);
            $template->blocknotice = $this->getSubTemplateContent('cookieconsent_blocknotice', true);
            $template->categories = $this->getSubTemplateContent('cookieconsent_categories');
            $template->languagesettings = $this->getSubTemplateContent('cookieconsent_language');
            $template->services = $this->getSubTemplateContent('cookieconsent_services');

            $result = $template->parse();
            $buffer = str_replace('</body>', $result . '</body>', $buffer);
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
            if (strpos($key, 'cookieconsent_') === 0) {
                $template->{substr($key, strlen('cookieconsent_'))} = $value;
            }
        }

        return $template;
    }

    /**
     * Get child template content
     * @param string $name
     * @return \Contao\FrontendTemplate
     */
    protected function getSubTemplateContent($template, $trimNewlines = false) {
        $template = new \Contao\FrontendTemplate($template);
        $template = $this->setData($template);
        $result = $template->parse();
        if ($trimNewlines === true) {
            $result = preg_replace('/\r|\n/', '', $result);
        }

        return $result;
    }
}
