<?php

/**
 *
 * Contao extension simplify
 *
 * @copyright  Martin Kozianka 2012-2014 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    simplify
 * @license    LGPL
 * @filesource
 */

$GLOBALS['FE_MOD']['news']['newslist']              = 'ContaoSimplify\SimplifyModuleNewsList';

$GLOBALS['TL_CRON']['hourly'][]                     = array('ContaoSimplify\Simplify', 'checkFeaturedStop');
$GLOBALS['TL_HOOKS']['parseArticles']['simplify']   = array('ContaoSimplify\Simplify', 'parseArticlesHook');

