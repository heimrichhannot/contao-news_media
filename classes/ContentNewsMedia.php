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


use Contao\File;

class ContentNewsMedia extends \ContentElement
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_player';

	/**
	 * Files object
	 * @var \FilesModel
	 */
	protected $objFiles;


	public function generate()
	{
		switch($this->playerType)
		{
			case 'playerSRC':
				if ($this->playerSRC == '')
				{
					return '';
				}

				return $this->generateContentSRC();

			break;
			case 'playerUrl':

				if ($this->playerUrl == '')
				{
					return '';
				}

				return $this->generateContentUrl();
			break;
		}
	}

	public function generateContentUrl()
	{
		$arrHeader = get_headers($this->playerUrl, true);

		if(!isset($arrHeader['Content-Length']) || !isset($arrHeader['Content-Type']))
		{
			return '';
		}

		$objFile = new \stdClass();

		$objFile->path = $this->playerUrl;
		$objFile->title = specialchars(basename($objFile->path));
		
		foreach($GLOBALS['TL_MIME'] as $key => $arrMime)
		{
			if($arrMime[0] == $arrHeader['Content-Type'])
			{
				$objFile->extension = $key;
				$objFile->mime = $arrMime[0];
				break;
			}
		}

		$this->objFiles = $objFile;

		return parent::generate();
	}

	public function generateContentSRC()
	{
		$source = deserialize($this->playerSRC);

		if (!is_array($source) || empty($source))
		{
			return '';
		}

		$objFiles = \FilesModel::findMultipleByUuidsAndExtensions($source, array('mp4','m4v','mov','wmv','webm','ogv','m4a','mp3','wma','mpeg','wav','ogg'));

		if ($objFiles === null)
		{
			return '';
		}

		// Display a list of files in the back end
		if (TL_MODE == 'BE')
		{
			$return = '<ul>';

			while ($objFiles->next())
			{
				$objFile = new \File($objFiles->path, true);
				$return .= '<li><img src="' . TL_ASSETS_URL . 'assets/contao/images/' . $objFile->icon . '" width="18" height="18" alt="" class="mime_icon"> <span>' . $objFile->name . '</span> <span class="size">(' . $this->getReadableSize($objFile->size) . ')</span></li>';
			}

			return $return . '</ul>';
		}

		$this->objFiles = $objFiles;

		return parent::generate();
	}



	protected function compile()
	{
		$this->Template->size = '';

		// Set the size
		if ($this->playerSize != '')
		{
			$size = deserialize($this->playerSize);

			if (is_array($size))
			{
				$this->Template->size = ' width="' . $size[0] . '" height="' . $size[1] . '"';
			}
		}

		$this->Template->poster = false;

		// Optional poster
		if ($this->posterSRC != '')
		{
			if (($objFile = \FilesModel::findByUuid($this->posterSRC)) !== null)
			{
				$this->Template->poster = $objFile->path;
			}
		}

		// Pre-sort the array by preference
		if (in_array($this->objFiles->extension , array('mp4','m4v','mov','wmv','webm','ogv')))
		{
			$this->Template->isVideo = true;
			$arrFiles = array('mp4'=>null, 'm4v'=>null, 'mov'=>null, 'wmv'=>null, 'webm'=>null, 'ogv'=>null);
		}
		else
		{
			$this->Template->isVideo = false;
			$arrFiles = array('m4a'=>null, 'mp3'=>null, 'wma'=>null, 'mpeg'=>null, 'wav'=>null, 'ogg'=>null);
		}


		switch($this->playerType)
		{
			case 'playerSRC':
				$arrFiles = $this->getPlayerSRCList($arrFiles);
			break;
			case 'playerUrl':
				$arrFiles = $this->getPlayerUrlList($arrFiles);
			break;
		}

		$this->Template->files = array_values(array_filter($arrFiles));
		$this->Template->autoplay = $this->autoplay;

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

	protected function getPlayerUrlList($arrFiles)
	{
		$arrFiles[$this->objFiles->extension] = $this->objFiles;
		
		return $arrFiles;
	}


	protected function getPlayerSRCList($arrFiles)
	{
		global $objPage;

		$arrFiles = array();

		$this->objFiles->reset();

		// Convert the language to a locale (see #5678)
		$strLanguage = str_replace('-', '_', $objPage->language);

		// Pass File objects to the template
		while ($this->objFiles->next())
		{
			$arrMeta = deserialize($this->objFiles->meta);

			if (is_array($arrMeta) && isset($arrMeta[$strLanguage]))
			{
				$strTitle = $arrMeta[$strLanguage]['title'];
			}
			else
			{
				$strTitle = $this->objFiles->name;
			}

			$objFile = new \File($this->objFiles->path, true);
			$objFile->title = specialchars($strTitle);

			$arrFiles[$objFile->extension] = $objFile;
		}

		return $arrFiles;
	}

}