<?php
namespace AdGrafik\AdxScss\XClass;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Arno Dudek <webmaster@adgrafik.at>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Rtehtmlarea\RteHtmlAreaBase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use AdGrafik\AdxScss\Utility\ScssUtility;

class RteHtmlAreaBaseHook extends RteHtmlAreaBase {

	/**
	 * @return string
	 */
	public function getContentCssFileName() {

		if (!isset($this->thisConfig['contentCSS']) || !$this->thisConfig['contentCSS']) {
			return parent::getContentCssFileName();
		}

		$this->thisConfig['contentCSS'] = $this->parseScssFile($this->thisConfig['contentCSS']);

		return parent::getContentCssFileName();
	}

	/**
	 * @return string
	 */
	public function getContentCssFileNames() {

		$contentCssFiles = is_array($this->thisConfig['contentCSS.']) ? $this->thisConfig['contentCSS.'] : array();

		foreach ($contentCssFiles as $key => &$contentCssFile) {
			$this->thisConfig['contentCSS.'][$key] = $this->parseScssFile($contentCssFile);
		}

		return parent::getContentCssFileNames();
	}

	/**
	 * @return string
	 */
	private function parseScssFile($contentCssFile) {

		// If not a SCSS file, nothing else to do.
		if (ScssUtility::isValidFile($contentCssFile) === FALSE) {
			return $contentCssFile;
		}

		$configuration = ScssUtility::getConfiguration($this->thePid);
		$scss = GeneralUtility::makeInstance('AdGrafik\\AdxScss\\Scss');

		return $scss->compile($absolutePathAndFilename, $configuration);
	}

}

?>