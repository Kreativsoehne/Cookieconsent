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
    <td class="tl_folder_tlist">' . $GLOBALS['TL_LANG']['tl_ks_cc_common']['LANGUAGE'][0] . '</td>
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
            throw new \Exception(sprintf('Missing sLanguageTable. [1614329292]', $dc->field));
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

	/**
	 * Return the paste item button
	 *
	 * @param Contao\DataContainer $dc
	 * @param array                $row
	 * @param string               $table
	 * @param boolean              $cr
	 * @param array                $arrClipboard
	 *
	 * @return string
	 */
	public function pasteItem(\Contao\DataContainer $dc, $row, $table, $cr, $arrClipboard=null)
	{
		$imagePasteAfter = \Contao\Image::getHtml('pasteafter.svg', sprintf($GLOBALS['TL_LANG'][$dc->table]['pasteafter'][1], $row['id']));

		return (
            ($arrClipboard['mode'] == 'cut' && $arrClipboard['id'] == $row['id'])
        ||  ($arrClipboard['mode'] == 'cutAll' && in_array($row['id'], $arrClipboard['id']))
        ||   $cr) ? \Contao\Image::getHtml('pasteafter_.svg') . ' ' : '<a href="' . $this->addToUrl('act=' . $arrClipboard['mode'] . '&amp;mode=1&amp;pid=' . $row['id'] . (!is_array($arrClipboard['id']) ? '&amp;id=' . $arrClipboard['id'] : '')) . '" title="' . \Contao\StringUtil::specialchars(sprintf($GLOBALS['TL_LANG'][$dc->table]['pasteafter'][1], $row['id'])) . '" onclick="Backend.getScrollOffset()">' . $imagePasteAfter . '</a> ';
	}

	// /**
	//  * Return the drag item button
	//  *
	//  * @param array  $row
	//  * @param string $href
	//  * @param string $label
	//  * @param string $title
	//  * @param string $icon
	//  * @param string $attributes
	//  *
	//  * @return string
	//  */
	// public function dragItem($row, $href, $label, $title, $icon, $attributes)
	// {
	// 	return '<button type="button" title="' . \Contao\StringUtil::specialchars($title) . '" ' . $attributes . '>' . \Contao\Image::getHtml($icon, $label) . '</button> ';
	// }
}
