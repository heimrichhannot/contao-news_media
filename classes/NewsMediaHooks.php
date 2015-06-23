<?php
/**
 * Contao Open Source CMS
 * 
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package newsmedia
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace HeimrichHannot\NewsMedia;


class NewsMediaHooks extends \Controller
{

	public function parseNewsArticlesHook($objTemplate, $arrNews, $objModule)
	{
		if(!$arrNews['addMedia']) return;

		NewsMedia::addMediaToTemplate($objTemplate, $arrNews, $objModule);
	}

}