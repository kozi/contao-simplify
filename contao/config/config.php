<?php

/**
 *
 * Contao extension simplify
 *
 * @copyright  Martin Kozianka 2012-2015 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    simplify
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_CRON']['hourly'][]                        = ['\ContaoSimplify\Simplify', 'checkFeaturedStop'];

$GLOBALS['TL_HOOKS']['parseArticles']['simplify']      = ['\ContaoSimplify\Simplify', 'parseArticlesHook'];
$GLOBALS['TL_HOOKS']['newsListFetchItems']['simplify'] = ['\ContaoSimplify\Simplify', 'newsListFetchItems'];