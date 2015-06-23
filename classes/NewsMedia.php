<?php
/**
 * Contao Open Source CMS
 * 
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package news_media
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\NewsMedia;


class NewsMedia extends \Frontend
{

	protected static $strTemplate = 'media_default';

	public static function addMediaToTemplate($objTemplate, $arrData, $objConfig)
	{
		$objItem                   = (object) $arrData;

		$objModel = \NewsModel::findByPk($objItem->id);

		if($objModel === null) return '';

		$objModel->customTpl = $objConfig->media_template ? $objConfig->media_template : static::$strTemplate;
		$objModel->imgSize = $objConfig->imgSize;
		$objModel->media_posterSRC = $objConfig->media_posterSRC;

		$objElement = new ContentNewsMedia($objModel);

		$objTemplate->mediaPlayer = $objElement->generate();
	}
}

