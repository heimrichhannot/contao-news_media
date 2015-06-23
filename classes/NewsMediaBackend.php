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


class NewsMediaBackend extends \Backend
{

	/**
	 * Return all media templates as array
	 * @return array
	 */
	public function getYouTubeTemplates()
	{
		return $this->getTemplateGroup('media_');
	}
}