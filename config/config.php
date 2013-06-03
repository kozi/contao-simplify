<?php

/**
 *
 * Contao extension simplify
 *
 * @copyright  Martin Kozianka 2012-2013 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    simplify
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_CRON']['hourly'][]                     = array('Simplify', 'checkFeaturedStop');

$GLOBALS['TL_HOOKS']['parseArticles'][]             = array('Simplify\Simplify', 'parseArticlesHook');
$GLOBALS['FE_MOD']['news']['simplify_sorted_news']  = 'ModuleNewsSortedList';

