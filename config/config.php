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


$GLOBALS['FE_MOD']['news']['newslist']              = 'Simplify\ModuleNewsList';

$GLOBALS['TL_CRON']['hourly'][]                     = array('Simplify', 'checkFeaturedStop');
$GLOBALS['TL_HOOKS']['parseArticles']['simplify']   = array('Simplify\Simplify', 'parseArticlesHook');

