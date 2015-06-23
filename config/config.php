<?php
/**
 * Contao Open Source CMS
 * 
 * Copyright (c) 2015 Heimrich & Hannot GmbH
 * @package news_media
 * @author Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseArticles'][] = array('\\HeimrichHannot\\NewsMedia\\NewsMediaHooks', 'parseNewsArticlesHook');