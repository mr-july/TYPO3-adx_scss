<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

// Set cache configuration.
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['adx_scss'] = array(
	'frontend' => 'TYPO3\\CMS\\Core\\Cache\\Frontend\\VariableFrontend',
	'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\FileBackend',
);

// Register page renderer hook.
if (TYPO3_MODE == 'FE') {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess']['adx_scss'] = 'AdGrafik\\AdxScss\\Hooks\\PageRendererHook->preProcess';
}

// Register clear cache hook.
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = 'AdGrafik\\AdxScss\\Hooks\\T3libTceMainHook->clearCachePostProc';

// Add XCLASS to rtehtmlarea, tinymce_rte and tinymce for tinymce4_rte.
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Rtehtmlarea\\RteHtmlAreaBase'] = array(
	'className' => 'AdGrafik\\Adxscss\\XClass\\RteHtmlAreaBase',
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['tx_tinymce_rte_base'] = array(
	'className' => 'AdGrafik\\AdxScss\\XClass\\TinyMceRteBase',
);
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['SGalinski\\Tinymce4Rte\\Editors\\RteBase'] = array(
	'className' => 'AdGrafik\\AdxScss\\XClass\\TinyMce4RteBase',
);

?>