<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2015 Leo Feyer
 *
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2012-2015 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    simplify
 * @license    LGPL
 * @filesource
 */
namespace ContaoSimplify;

/**
 * Class Simplify
 *
 * @copyright  Martin Kozianka 2012-2015 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    Controller
 */


use Contao\NewsArchiveModel;

class Simplify extends \System
{
    public function parseArticlesHook(&$objTemplate, $row, $newsModule)
    {
		global $objPage;

        $objArchive = NewsArchiveModel::findByPk($row['pid']);
        if ($objArchive !== null && $objArchive->simplify == '1' && $objArchive->simplify_news_teaser == '1')
        {
            $text = $row['text'];
            $text = ($objPage->outputFormat == 'xhtml') ? \StringUtil::toXhtml($text) : \StringUtil::toHtml5($text);
            $objTemplate->text = \StringUtil::encodeEmail($text);
        }
	}

    public static function checkFeaturedStop()
    {
        $idArr = [];
        $now   = time();
        $db    = \Database::getInstance();

        // Search for tl_news entries with featured_stop date in the past
        $result = $db->prepare('SELECT id FROM tl_news WHERE featured = ? AND featured_stop != ? AND featured_stop < ?')
                    ->execute('1', '', $now);

        while ($result->next())
        {
            $idArr[] = $result->id;
        }

        if (count($idArr) > 0)
        {
            $ids = implode(',', $idArr);
            static::log('Simplify - Check "featured_stop" values (Updated entries: '.$ids.')', 'Simplify checkFeaturedStop()', TL_CRON);

            // Remove featured flag from tl_news entries
            $db->prepare("UPDATE tl_news SET tstamp = ". $now .", featured = ? WHERE id IN (".$ids.")")->execute('');
        }
    }

    public function newsListFetchItems($newsArchives, $blnFeatured, $limit, $offset, $module)
    {
        $arrOptions = [];
        if ($module !== null && $module->simplify_sorting !== null && $module->simplify_sorting != '')
        {
            $order = str_replace( ['_asc', '_desc'], [' ASC', ' DESC'], $module->simplify_sorting);
            $arrOptions['order']  = ($order === 'random') ? 'RAND()' : 'tl_news.'.$order;
        }
        return \NewsModel::findPublishedByPids($newsArchives, $blnFeatured, $limit, $offset, $arrOptions);
    }
}
