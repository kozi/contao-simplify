<?php

/**
 *
 * Contao extension simplify
 *
 * @copyright  Martin Kozianka 2012-2017
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
    $GLOBALS['TL_MOOTOOLS'][] = "<style>"
        .".tl_content_left.simplify { font-weight: bold; }"
        .".tl_content_left.simplify > span { font-weight: normal; }"
    ."<style>";
}
