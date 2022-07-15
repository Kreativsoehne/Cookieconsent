<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2022 Kreativ&Söhne GmbH

 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

namespace Kreativsoehne\Cookieconsent\Content;

use Contao\BackendTemplate;
use Contao\ContentElement;

/**
 * Class ToggleContentElement
 */
class ToggleContentElement extends ContentElement
{
    /**
     * @inheritDoc
     */
    protected $strTemplate = 'ce_cookieconsent_toggle';

    /**
     * @inheritDoc
     */
    protected function compile()
    {
        if (TL_MODE === 'BE') {
            $this->compileForBackend();
        } else {
            $this->compileForFrontend();
        }
    }

    /**
     * Compile for backend view
     */
    protected function compileForBackend()
    {
        $this->strTemplate = 'be_wildcard';
        $this->Template = new BackendTemplate($this->strTemplate);
        $this->Template->title = $GLOBALS['TL_LANG']['MCS']['cookieconsent_toggle_label'];

        // Only default options set in template for now
        // if (isset($this->iconClass) === true && empty($this->iconClass) === false) {
        //     $this->Template->wildcard = '<i class="' . $this->iconClass . '" aria-hidden="true"></i>';
        // }
        // if (isset($this->label) === true && empty($this->iconClass) === false) {
        //     $this->Template->title = $this->label;
        // }
    }

    /**
     * Compile for frontend view
     */
    protected function compileForFrontend()
    {
        // Only default options set in template for now
        // if (isset($this->iconClass) === true) {
        //     $this->Template->iconClass = $this->iconClass;
        // }
        // if (isset($this->label) === true) {
        //     $this->Template->label = $this->label;
        // }
    }
}
