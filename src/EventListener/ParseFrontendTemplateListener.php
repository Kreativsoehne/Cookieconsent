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
use Kreativsoehne\Cookieconsent\Model\Category;
use Kreativsoehne\Cookieconsent\Model\CategoryLanguage;

/**
 * @Hook("parseFrontendTemplate")
 */
class ParseFrontendTemplateListener
{
    /**
     * Basic cache for category names to prevent multiple database queries.
     * @var string[]
     * */
    protected static $categoryNames = [];

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
     * @param string $buffer
     * @param string $template
     * @param FrontendTemplate $frontendTemplate
     * @return string
     */
    public function __invoke(string $buffer, string $templateName, FrontendTemplate $template): string
    {
        $category = $this->getCategoryForTemplate($templateName);

        if (null === $category || true === Category::isCategoryWanted($category)) {
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
     * Render a block notice instead of the content
     * @param string $category
     * @return string
     */
    protected function renderBlockNotice(string $category): string
    {
        $categoryName = $this->getCategoryName($category);

        $template = new FrontendTemplate('cookieconsent_blocknotice');
        $template->category = $categoryName;
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

    protected function getCategoryName(string $alias): string
    {
        $language = $GLOBALS['TL_LANGUAGE'];
        if (false === isset(self::$categoryNames[$language])) {
            self::$categoryNames[$language] = [];
        }

        if (false === isset(self::$categoryNames[$language][$alias])) {
            self::$categoryNames[$language][$alias] = $alias;

            $category = Category::findByAlias($alias);

            if (null !== $category) {
                $categoryLanguage = CategoryLanguage::findOneBy(['pid = ?', 'language = ?'], [$category->id, $language]);

                if (null !== $categoryLanguage) {
                    self::$categoryNames[$language][$alias] = $categoryLanguage->name;
                }
            }
        }

        return self::$categoryNames[$language][$alias];
    }
}
