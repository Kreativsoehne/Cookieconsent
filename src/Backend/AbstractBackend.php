<?php

/*
 * Cookieconsent module for Contao Open Source CMS
 * Copyright (C) 2021 Kreativ&Söhne GmbH

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
     * Table name for Backend area
     *
     * @var string
     */
    protected $strTable = null;

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
     * @return string
     */
    public function listLanguageRows($arrRow)
    {
        if (empty($this->sLanguageTable) === true) {
            return 'Missing language table name. [1614331419]';
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
     * @param string $strId
     * @param \DcaWizard $widget
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
     * Check if the language field is unique per item
     *
     * @param mixed $varValue
     * @param \DataContainer $dc
     * @return mixed
     * @throws \Exception
     */
    public function validateLanguageField($varValue, \DataContainer $dc)
    {
        if (empty($this->sLanguageTable) === true) {
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
	 * @param \Contao\DataContainer $dc
	 * @param array $row
	 * @param string $table
	 * @param boolean $cr
	 * @param array $arrClipboard
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

	/**
	 * Add an image to each page in the tree
	 *
	 * @param array $row
	 * @param string $label
	 * @return string
     * @todo Use custom icon for Category & Service
	 */
	public function itemIcon($row, $label)
	{
		$image = 'articles';

		if (!$row['published'])
		{
			$image .= '_';
		}

        return \Contao\Image::getHtml($image . '.svg', '', 'data-icon="' . $image . '.svg" data-icon-disabled="' . rtrim($image, '_') . '_.svg"') . $label;
	}

	/**
	 * Return the "toggle visibility" button
	 *
	 * @param array $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
        if (empty($this->strTable) === true) {
            return '';
        }

        if (\Contao\Input::get('tid'))
        {
            $this->toggleVisibility(\Contao\Input::get('tid'), (\Contao\Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? '' : 1);

        if (!$row['published']) {
            $icon = 'invisible.svg';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . \Contao\StringUtil::specialchars($title) . '"' . $attributes . '>' . \Contao\Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"') . '</a> ';
	}

	/**
	 * Disable/enable a user group
	 *
	 * @param integer $intId
	 * @param boolean $blnVisible
	 * @param \Contao\DataContainer $dc
	 * @throws \Contao\CoreBundle\Exception\AccessDeniedException
	 */
	public function toggleVisibility($intId, $blnVisible, \Contao\DataContainer $dc=null)
	{
        if (empty($this->strTable) === true) {
            return;
        }
        $strTable = $this->strTable;

        // Set the ID and action
        \Contao\Input::setGet('id', $intId);
        \Contao\Input::setGet('act', 'toggle');

		if ($dc)
		{
            $dc->id = $intId; // see #8043
		}

		// Trigger the onload_callback
		if (is_array($GLOBALS['TL_DCA'][$strTable]['config']['onload_callback']))
		{
            foreach ($GLOBALS['TL_DCA'][$strTable]['config']['onload_callback'] as $callback)
			{
                if (is_array($callback))
				{
                    $this->import($callback[0]);
					$this->{$callback[0]}->{$callback[1]}($dc);
				}
				elseif (is_callable($callback))
				{
                    $callback($dc);
				}
			}
		}

		// Set the current record
		if ($dc)
		{
			$objRow = $this->Database->prepare("SELECT * FROM $strTable WHERE id=?")
									 ->limit(1)
									 ->execute($intId);

			if ($objRow->numRows)
			{
				$dc->activeRecord = $objRow;
			}
		}

		$objVersions = new \Contao\Versions($strTable, $intId);
		$objVersions->initialize();

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA'][$strTable]['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA'][$strTable]['fields']['published']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, $dc);
				}
			}
		}

		$time = time();

		// Update the database
		$this->Database->prepare("UPDATE $strTable SET tstamp=$time, published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
					   ->execute($intId);

		if ($dc)
		{
			$dc->activeRecord->tstamp = $time;
			$dc->activeRecord->published = ($blnVisible ? '1' : '');
		}

		// Trigger the onsubmit_callback
		if (is_array($GLOBALS['TL_DCA'][$strTable]['config']['onsubmit_callback']))
		{
			foreach ($GLOBALS['TL_DCA'][$strTable]['config']['onsubmit_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$this->{$callback[0]}->{$callback[1]}($dc);
				}
				elseif (is_callable($callback))
				{
					$callback($dc);
				}
			}
		}

		$objVersions->create();
	}
}
