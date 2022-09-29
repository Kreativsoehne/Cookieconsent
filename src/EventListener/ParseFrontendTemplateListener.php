<?php

/**
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2022 Kreativ&Söhne GmbH
 *
 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

namespace Kreativsoehne\Cookieconsent\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\FrontendTemplate;

/**
 * @Hook("parseFrontendTemplate")
 */
class ParseFrontendTemplateListener
{
    /**
     * Map of templateName expressions to cookie category aliases
     * @var array[string]
     */
    protected $templateNameToCategoryMap = [
        '/^analytics_/' => 'analytics',
        '/^(ce_|customelement_|mod_)(vimeo|youtube)/' => 'external',
        '/^(ce_|customelement_|mod_)(.+_)*(gmap|googlemap)/' => 'external'
    ];

    /**
     * Cache of Cookie Categories with their wanted state
     * @var array[string]
     */
    protected static $categoryStates = null;

    /**
     * @param string $buffer
     * @param string $template
     * @param FrontendTemplate $frontendTemplate
     * @return string
     */
    public function __invoke(string $buffer, string $templateName, FrontendTemplate $template): string
    {
        $category = $this->getCategoryForTemplate($templateName);

        if (null === $category || true === $this->isCategoryWanted($category)) {
            return $buffer;
        }

        // On analytics just return nothing for now
        if ($category === 'analytics') {
            return $this->renderBlockComment($templateName, $category);
        }

        return $this->renderBlockComment($templateName, $category) . $this->renderBlockNotice($category);
    }

    /**
     * Check if template name fits a name or RegExp in the category map
     * @param string $templateName
     * @return string|null
     */
    protected function getCategoryForTemplate(string $templateName): ?string
    {

        foreach ($this->templateNameToCategoryMap as $nameOrRegExp => $category) {
            if (
                $nameOrRegExp === $templateName ||
                (false !== @preg_match($nameOrRegExp, null) && 1 === preg_match($nameOrRegExp, $templateName))
            ) {
                return $category;
            }
        }

        return null;
    }

    /**
     * Get the wanted states of all cookie categories
     * @return array[bool]
     */
    protected function getCookieCategoryStates(): array
    {
        $ccChoices = json_decode(html_entity_decode(\Input::cookie('cconsent')));

        if (
            null === $ccChoices ||
            false === is_object($ccChoices) ||
            false === is_object($ccChoices->categories)
        ) {
            return [];
        }

        $result = [];
        foreach ($ccChoices->categories as $category => $settings) {
            $result[$category] = false;

            if (true === is_object($settings)) {
                $result[$category] = $settings->wanted === true;
            }
        }

        return $result;
    }

    /**
     * Check if category is wanted
     * @param string $category
     * @return bool
     */
    protected function isCategoryWanted(string $category): bool
    {
        if (self::$categoryStates === null) {
            self::$categoryStates = $this->getCookieCategoryStates();
        }

        return self::$categoryStates[$category] ?? false;
    }

    /**
     * Render a block notice instead of the content
     * @param string $category
     * @return string
     */
    protected function renderBlockNotice(string $category): string
    {
        $template = new FrontendTemplate('cookieconsent_blocknotice');
        return $template->parse();
    }

    /**
     * Simple comment to mark the blocked content
     * @param string $category
     * @return string
     */
    protected function renderBlockComment(string $templateName, string $category): string
    {
        if (
            false === \Contao\Config::get('debugMode') ||
            true === empty($GLOBALS['TL_LANG']['MCS']['cookieconsent_blockcomment'])
        ) {
            return '';
        }

        $replaceMap = [
            '##templateName##' => $templateName,
            '##category##' => $category
        ];

        return str_replace(
            array_keys($replaceMap),
            array_values($replaceMap),
            $GLOBALS['TL_LANG']['MCS']['cookieconsent_blockcomment']
        );
    }
}
