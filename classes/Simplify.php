<?php

namespace Simplify;

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2013 Leo Feyer
 *
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2012-2013 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    simplify
 * @license    LGPL
 * @filesource
 */


/**
 * Class Simplify
 *
 * @copyright  Martin Kozianka 2012
 * @author     Martin Kozianka <martin@kozianka.de>
 * @package    Controller
 */

class Simplify extends \Contao\System {

	public function parseArticlesHook(&$objTemplate, $row, $newsModule) {
		global $objPage;
		if (array_key_exists('simplify_news', $GLOBALS['TL_CONFIG']) && $GLOBALS['TL_CONFIG']['simplify_news'] === true 
			&& array_key_exists('simplify_news_teaser', $GLOBALS['TL_CONFIG']) && $GLOBALS['TL_CONFIG']['simplify_news_teaser'] === true) {
			
			$text = $row['text'];
			$text = ($objPage->outputFormat == 'xhtml') ? \String::toXhtml($text) : \String::toHtml5($text);
			$objTemplate->text = \String::encodeEmail($text);
			
		}
	}
	
}


