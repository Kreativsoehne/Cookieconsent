<?php

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
            $template = $this->getTemplate($rootPage);
            $template = $this->setData($template, $rootPage);

            $result = $template->parse();
            $buffer = str_replace('</body>', $result . '</body>', $buffer);
        }

        return $buffer;
    }

    /**
     * Get cookieconsent template
     * @param \Contao\PageModel $rootPage
     * @return \Contao\FrontendTemplate
     */
    protected function getTemplate($rootPage) {
        $template = new \Contao\FrontendTemplate('cookieconsent');
        return $template;
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
}
