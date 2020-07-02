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
     * Output cookieconsent on frontend template if enabled
     * @param string $buffer
     * @return string
     */
    public function onOutputFrontendTemplate($buffer)
    {
        $rootPage = \Contao\PageModel::findByPk($GLOBALS['objPage']->rootId);

        if ($rootPage !== null && empty($rootPage->cookieconsent_enable) === false) {
            $template = new \Contao\FrontendTemplate('cookieconsent');
            $template = $this->setData($template, $rootPage);
            $template->blocknotice = $this->generateBlockNotice();

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
    protected function setData($template, $rootPage) {
        $rowData = $rootPage->row();

        foreach ($rowData as $key => $value) {
            if (strpos($key, 'cookieconsent_') === 0) {
                // echo(substr($key, strlen('cookieconsent_')) . $value . '<br>');
                $template->{substr($key, strlen('cookieconsent_'))} = $value;
            }
        }

        return $template;
    }

    /**
     * Get cookieconsent notice
     * @param string $name
     * @return \Contao\FrontendTemplate
     */
    protected function generateBlockNotice() {
        $template = new \Contao\FrontendTemplate('cookieblocknotice');
        $result = $template->parse();
        $result = preg_replace('/\r|\n/', '', $result);
        return $result;
    }
}
