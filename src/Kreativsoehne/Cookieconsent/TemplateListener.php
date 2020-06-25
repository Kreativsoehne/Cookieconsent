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
            $template = $this->getCookieconsentTemplate($rootPage);
            $result = $template->parse();
            $buffer = str_replace('</body>', $result . '</body>', $buffer);
        }

        return $buffer;
    }

    /**
     * Get cookieconsent template
     *
     * @param \Contao\PageModel $rootPage
     * @return \Contao\FrontendTemplate
     */
    protected function getCookieconsentTemplate($rootPage) {
        $template = new \Contao\FrontendTemplate('cookieconsent');
        $template->cookie = sprintf('cookieconsent_%s', $rootPage->id);
        return $template;
    }
}
