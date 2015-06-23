<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 *
 * @package news_media
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$dc = &$GLOBALS['TL_DCA']['tl_module'];

/**
 * Palettes
 */
$dc['palettes']['newslist']    = str_replace('imgSize', 'imgSize;{media_legend},media_template,media_posterSRC', $dc['palettes']['newslist']);
$dc['palettes']['newsarchive'] = str_replace('imgSize', 'imgSize;{media_legend},media_template,media_posterSRC', $dc['palettes']['newsarchive']);
$dc['palettes']['newsreader']  = str_replace('imgSize', 'imgSize;{media_legend},media_template,media_posterSRC', $dc['palettes']['newsreader']);


/**
 * Fields
 */
$arrFields = array
(
	'media_template'  => array
	(
		'label'            => &$GLOBALS['TL_LANG']['tl_module']['media_template'],
		'default'          => 'youtube_default',
		'exclude'          => true,
		'inputType'        => 'select',
		'options_callback' => array('\\HeimrichHannot\\NewsMedia\\NewsMediaBackend', 'getYouTubeTemplates'),
		'eval'             => array('tl_class' => 'w50'),
		'sql'              => "varchar(64) NOT NULL default ''"
	),
	'media_posterSRC' => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_module']['media_posterSRC'],
		'exclude'   => true,
		'inputType' => 'fileTree',
		'eval'      => array('filesOnly' => true, 'fieldType' => 'radio', 'tl_class' => 'clr'),
		'sql'       => "binary(16) NULL"
	)
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);