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

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$dc = &$GLOBALS['TL_DCA']['tl_news'];

Controller::loadDataContainer('tl_content');

/**
 * Palettes
 */
PaletteManipulator::create()
    ->addLegend('media_legend', 'image_legend', PaletteManipulator::POSITION_BEFORE)
    ->addField('addMedia', 'media_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_news')
    ->applyToPalette('internal', 'tl_news')
    ->applyToPalette('article', 'tl_news')
    ->applyToPalette('external', 'tl_news')
;

$dc['palettes']['__selector__'][] = 'addMedia';

/**
 * Subpalettes
 */

//$dc['subpalettes']['addMedia'] = 'playerType,posterSRC,autoplay';

$dc['subpalettes']['addMedia'] = 'playerType';

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


class tl_news_media extends Backend
{
    /**
     * Modify the palette according to the checkboxes selected
     */
    public function modifyPalettes(DataContainer $dc): void
    {
        $objNews = NewsModel::findById($dc->id);

        if ($objNews === null) {
            return;
        }

        $pm = PaletteManipulator::create()
            ->addField('posterSRC', 'playerType')
            ->addField('autoplay', 'playerType');

        switch ($objNews->playerType) {
            case 'playerSRC':
                $pm->addField('playerSRC', 'playerType');
                break;
            case 'playerUrl':
                $pm->addField('playerUrl', 'playerType');
                break;
        }

        $pm->applyToSubpalette('addMedia', 'tl_news');
    }
}
