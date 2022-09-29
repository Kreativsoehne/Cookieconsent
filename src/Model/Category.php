<?php

/**
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2022 Kreativ&Söhne GmbH
 *
 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

namespace Kreativsoehne\Cookieconsent\Model;

/**
 * Category
 */
class Category extends \Contao\Model
{

    /**
     * @inheritDoc
     */
    protected static $strTable = 'tl_ks_cc_category';

    /**
     * Cache of category wanted states based on whats in the cookie
     * @var array[string]
     */
    protected static $wantedStates = null;

    /**
     * Check if specific category is wanted
     * @param string $category
     * @return bool
     */
    public static function isCategoryWanted(string $category): bool
    {
        if (self::$wantedStates === null) {
            self::$wantedStates = self::getWantedStatesFromCookie();
        }

        return self::$wantedStates[$category] ?? false;
    }

    /**
     * Get the wanted states of all cookie categories
     * @return array[bool]
     */
    protected static function getWantedStatesFromCookie(): array
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
            $result[$category] = true === is_object($settings) && true === $settings->wanted;
        }

        return $result;
    }
}
