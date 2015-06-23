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

$dc = &$GLOBALS['TL_DCA']['tl_news'];

\Controller::loadDataContainer('tl_content');

/**
 * Palettes
 */
$dc['palettes']['default']        = str_replace('{image_legend}', '{media_legend},addMedia;{image_legend}', $dc['palettes']['default']);
$dc['palettes']['__selector__'][] = 'addMedia';

/**
 * Subpalettes
 */

$dc['subpalettes']['addMedia'] = 'playerSRC,posterSRC,autoplay';

/**
 * Fields
 */
$arrFields = array
(
	'addMedia'  => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_news']['addMedia'],
		'exclude'   => true,
		'inputType' => 'checkbox',
		'eval'      => array('submitOnChange' => true),
		'sql'       => "char(1) NOT NULL default ''"
	),
	'playerSRC' => &$GLOBALS['TL_DCA']['tl_content']['fields']['playerSRC'],
	'autoplay'  => &$GLOBALS['TL_DCA']['tl_content']['fields']['autoplay'],
	'posterSRC' => &$GLOBALS['TL_DCA']['tl_content']['fields']['posterSRC']
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);


class tl_news_media extends \Backend
{
	/**
	 * Modify the palette according to the checkboxes selected
	 *
	 * @param mixed
	 * @param DataContainer
	 *
	 * @return mixed
	 */
//	public function modifyPalettes()
//	{
//		$objNews = \NewsModel::findById($this->Input->get('id'));
//		$dc      = &$GLOBALS['TL_DCA']['tl_news'];
//		if (!$objNews->addPreviewImage) {
//			$dc['subpalettes']['addMedia'] =
//				str_replace('playerSRC,posterSRC,playerSize,autoplay,', '', $dc['subpalettes']['addMedia']);
//		}
//	}


}
