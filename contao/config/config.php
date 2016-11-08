<?php

/**
 *
 * Contao extension simplify
 *
 * @copyright  Martin Kozianka 2012-2016 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    simplify
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_HOOKS']['parseArticles']['simplify']      = ['\ContaoSimplify\Simplify', 'parseArticlesHook'];
$GLOBALS['TL_HOOKS']['newsListFetchItems']['simplify'] = ['\ContaoSimplify\Simplify', 'newsListFetchItems'];
$GLOBALS['TL_CRON']['hourly'][]                        = ['\ContaoSimplify\Simplify', 'checkFeaturedStop'];

if(TL_MODE === 'BE')
{
    $GLOBALS['TL_CSS'][] = 'system/modules/simplify/assets/be_style.css||static';
}
