<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2020 Kreativ&Söhne GmbH

 * @author  Kreativ&Söhne GmbH <https://www.kreativundsoehne.de>
 * @license MIT
 */

namespace Kreativsoehne\Cookieconsent\Backend;

/**
 * AbstractBackend
 */
abstract class AbstractBackend extends \Contao\Backend
{
    /**
     * Available translations
     * @var array
     */
    protected $arrTranslations = [];

    /**
     * Language table name for Backend area
     *
     * @var string
     */
    protected $sLanguageTable = null;

    /**
     * child_record_callback
     *
     * @param array $arrRow
     *
     * @return string
     */
    public function listLanguageRows($arrRow)
    {
        if ($this->sLanguageTable === null) {
            return 'Missing language table name';
        }

        if (0 === count($this->arrTranslations)) {
            $this->arrTranslations = \System::getLanguages();
        }

        $sLanguageTable = $this->sLanguageTable;
        $arrTranslations =  \Database::getInstance()->prepare("SELECT language FROM $sLanguageTable WHERE pid=?")->execute($arrRow['id'])->fetchEach('language');

        $strBuffer = '
<div class="cte_type ' . (($arrRow['published']) ? 'published' : 'unpublished') . '"><strong>' . $arrRow['title'] . '</strong></div>
<div>
<ul>';

        foreach ($arrTranslations as $strLang) {
            $strBuffer .= '<li>&#10148; ' . $this->arrTranslations[$strLang] . '</li>';
        }

        $strBuffer .= '</ul></div>';

        return $strBuffer;
    }

    /**
     * Generate a list for the dcaWizard displaying the languages
     *
     * @param \Database\Result $objRecords
     * @param string           $strId
     * @param \DcaWizard       $widget
     *
     * @return string
     */
    public function generateLanguageWizardList($objRecords, $strId, $widget)
    {
        $strReturn = '
<table class="tl_listing showColumns">
<thead>
    <td class="tl_folder_tlist">' . 'LB Language'. '</td>
    <td class="tl_folder_tlist"></td>
</thead>
<tbody>';

        $arrLanguages = \System::getLanguages();

        while ($objRecords->next()) {
            $row = $objRecords->row();

            $strReturn .= '
<tr>
    <td class="tl_file_list">' . $arrLanguages[$objRecords->language] . '</td>
    <td class="tl_file_list">' . $widget->generateRowOperation('edit', $row) . '</td>
</tr>
';
        }

        $strReturn .= '
</tbody>
</table>';

        return $strReturn;
    }

    /**
     * Check if the language field is unique per message
     *
     * @param mixed          $varValue
     * @param \DataContainer $dc
     *
     * @return mixed
     * @throws \Exception
     */
    public function validateLanguageField($varValue, \DataContainer $dc)
    {
        throw new \Exception(sprintf('validateLanguageField', $dc->field));
        if ($this->sLanguageTable === null) {
            throw new \Exception(sprintf('LB Missing sLanguageTable', $dc->field));
        }

        $sLanguageTable = $this->sLanguageTable;

        $objLanguages = $this->Database->prepare("SELECT id FROM $sLanguageTable WHERE language=? AND pid=? AND id!=?")
            ->limit(1)
            ->execute($varValue, $dc->activeRecord->pid, $dc->id);

        if ($objLanguages->numRows) {
            throw new \Exception(sprintf($GLOBALS['TL_LANG']['ERR']['unique'], $dc->field));
        }

        return $varValue;
    }
}
