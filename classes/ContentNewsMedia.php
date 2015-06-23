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

namespace HeimrichHannot\NewsMedia;


class ContentNewsMedia extends \ContentMedia
{


	protected function compile()
	{
		parent::compile();

		$singleSRC = '';

		if($this->media_posterSRC)
		{
			$objModel = \FilesModel::findByUuid($this->media_posterSRC);

			if ($objModel !== null) {
				$singleSRC = $objModel->path;
			}
		}


		if ($this->posterSRC != '') {
			$objModel = \FilesModel::findByUuid($this->posterSRC);

			if ($objModel !== null) {
				$singleSRC = $objModel->path;
			}
		}

		if (file_exists(TL_ROOT . '/' . $singleSRC)) {
			$arrImage['singleSRC'] = $singleSRC;
			$arrImage['alt']       = 'media-image';

			if ($this->imgSize != '' || $this->size) {
				$size = deserialize($this->imgSize ? $this->imgSize : $this->size);

				if ($size[0] > 0 || $size[1] > 0 || is_numeric($size[2]))
				{
					$arrImage['size'] = $this->imgSize;
				}
			}

			\Controller::addImageToTemplate($this->Template, $arrImage);
		}
	}

}