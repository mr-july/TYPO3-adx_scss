<?php
namespace AdGrafik\AdxScss\Hooks;

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

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use AdGrafik\AdxScss\Utility\ScssUtility;

class PageRendererHook {

	/**
	 * Hook function for parse files with the suffix ".scss".
	 *
	 * @param array $parameters
	 * @param \TYPO3\CMS\Core\Page\PageRenderer $parentObject
	 * @return void
	 */
	public function preProcess($parameters, PageRenderer $parentObject) {

		$scss = GeneralUtility::makeInstance('AdGrafik\\AdxScss\\Scss');
		$cssFiles = array();

		foreach ($parameters['cssFiles'] as $pathAndFilename => $cssConfiguration) {

			// If not a SCSS file, nothing else to do.
			if (pathinfo($pathAndFilename,  PATHINFO_EXTENSION) !== 'scss') {
				$cssFiles[$pathAndFilename] = $cssConfiguration;
				continue;
			}

			$configuration = ScssUtility::getConfiguration($GLOBALS['TSFE']->cObj);
			$compiledPathAndFilename = $scss->compile($pathAndFilename, $configuration);

			$cssConfiguration['file'] = $compiledPathAndFilename;
			$cssFiles[$compiledPathAndFilename] = $cssConfiguration;
		}

		$parameters['cssFiles'] = $cssFiles;
	}

}

?>