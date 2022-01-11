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

$dc['subpalettes']['addMedia'] = 'playerType,posterSRC,autoplay';

/**
 * Fields
 */
$arrFields = array
(
	'addMedia'   => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_news']['addMedia'],
		'exclude'   => true,
		'inputType' => 'checkbox',
		'eval'      => array('submitOnChange' => true),
		'sql'       => "char(1) NOT NULL default ''"
	),
	'playerType' => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_news']['playerType'],
		'default'   => 'text',
		'exclude'   => true,
		'filter'    => true,
		'inputType' => 'select',
		'default'   => 'playerUrl',
		'options'   => array('playerSRC', 'playerUrl'),
		'reference' => &$GLOBALS['TL_LANG']['tl_news']['playerType_reference'],
		'eval'      => array('chosen' => true, 'submitOnChange' => true),
		'sql'       => "varchar(32) NOT NULL default ''"
	),
	'playerSRC'  => &$GLOBALS['TL_DCA']['tl_content']['fields']['playerSRC'],
	'playerUrl'  => array
	(
		'label'     => &$GLOBALS['TL_LANG']['tl_news']['playerUrl'],
		'exclude'   => true,
		'search'    => true,
		'inputType' => 'text',
		'eval'      => array('mandatory' => false, 'decodeEntities' => true, 'maxlength' => 255),
		'sql'       => "varchar(255) NOT NULL default ''"
	),
	'autoplay'   => [
        'label'                   => &$GLOBALS['TL_LANG']['tl_news']['autoplay'],
        'exclude'                 => true,
        'inputType'               => 'checkbox',
        'eval'                    => array('tl_class'=>'w50 m12'),
        'sql'                     => "char(1) NOT NULL default ''"
    ],
	'posterSRC'  => &$GLOBALS['TL_DCA']['tl_content']['fields']['posterSRC']
);



$dc['fields'] = array_merge($dc['fields'], $arrFields);

/**
 * Callbacks
 */

$dc['config']['onload_callback'][] = array('tl_news_media', 'modifyPalettes');


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
	public function modifyPalettes(\DataContainer $dc)
	{
		$objNews = \NewsModel::findById($dc->id);

		if($objNews === null) return;

		$dc      = &$GLOBALS['TL_DCA']['tl_news'];

		// default replacement == playerUrl
		$strReplace = 'playerType,playerUrl';

		if($objNews !== null)
		{
			switch($objNews->playerType)
			{
				case 'playerSRC':
					$strReplace = str_replace('playerType', 'playerType,playerSRC', $dc['subpalettes']['addMedia']);
				break;
			}
		}

		$dc['subpalettes']['addMedia'] = str_replace('playerType', $strReplace, $dc['subpalettes']['addMedia']);
	}


}
