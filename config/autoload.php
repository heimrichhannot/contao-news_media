<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HeimrichHannot',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'HeimrichHannot\NewsMedia\NewsMedia'        => 'system/modules/news_media/classes/NewsMedia.php',
	'HeimrichHannot\NewsMedia\ContentNewsMedia' => 'system/modules/news_media/classes/ContentNewsMedia.php',
	'HeimrichHannot\NewsMedia\NewsMediaBackend' => 'system/modules/news_media/classes/NewsMediaBackend.php',
	'HeimrichHannot\NewsMedia\NewsMediaHooks'   => 'system/modules/news_media/classes/NewsMediaHooks.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'media_image'   => 'system/modules/news_media/templates/media',
	'media_default' => 'system/modules/news_media/templates/media',
	'media_player'  => 'system/modules/news_media/templates/media',
));
