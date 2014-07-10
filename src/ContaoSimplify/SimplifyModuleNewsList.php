<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2014 Leo Feyer
 *
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2012-2014 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    simplify
 * @license    LGPL
 * @filesource
 */
namespace ContaoSimplify;

/**
 * Class ModuleNewsList
 *
 * @copyright  Martin Kozianka 2012-2014
 * @author     Martin Kozianka <martin@kozianka.de>
 * @package    Controller
 */

class SimplifyModuleNewsList extends \ModuleNewsList {




    /**
     * Generate the module
     */
    protected function compile()
    {
        $offset = intval($this->skipFirst);
        $limit = null;

        // Maximum number of items
        if ($this->numberOfItems > 0)
        {
            $limit = $this->numberOfItems;
        }

        // Handle featured news
        if ($this->news_featured == 'featured')
        {
            $blnFeatured = true;
        }
        elseif ($this->news_featured == 'unfeatured')
        {
            $blnFeatured = false;
        }
        else
        {
            $blnFeatured = null;
        }

        $this->Template->articles = array();
        $this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyList'];

        // Get the total number of items
        $intTotal = \NewsModel::countPublishedByPids($this->news_archives, $blnFeatured);

        if ($intTotal < 1)
        {
            return;
        }

        $total = $intTotal - $offset;

        // Split the results
        if ($this->perPage > 0 && (!isset($limit) || $this->numberOfItems > $this->perPage))
        {
            // Adjust the overall limit
            if (isset($limit))
            {
                $total = min($limit, $total);
            }

            // Get the current page
            $id = 'page_n' . $this->id;
            $page = \Input::get($id) ?: 1;

            // Do not index or cache the page if the page number is outside the range
            if ($page < 1 || $page > max(ceil($total/$this->perPage), 1))
            {
                global $objPage;
                $objPage->noSearch = 1;
                $objPage->cache = 0;

                // Send a 404 header
                header('HTTP/1.1 404 Not Found');
                return;
            }

            // Set limit and offset
            $limit = $this->perPage;
            $offset += (max($page, 1) - 1) * $this->perPage;
            $skip = intval($this->skipFirst);

            // Overall limit
            if ($offset + $limit > $total + $skip)
            {
                $limit = $total + $skip - $offset;
            }

            // Add the pagination menu
            $objPagination = new \Pagination($total, $this->perPage, \Config::get('maxPaginationLinks'), $id);
            $this->Template->pagination = $objPagination->generate("\n  ");
        }


        // Added ##### Added ##### Added ##### Added ##### Added ##### Added ##### Added #####
        // Added $arrOptions in the both statements below
        $arrOptions = array();
        if ($this->simplify_sorting !== '') {
            $order = str_replace( array('_asc', '_desc'), array(' ASC', ' DESC'), $this->simplify_sorting);
            $arrOptions['order']  = ($order === 'random') ? 'RAND()' : 'tl_news.'.$order;
        }

        // Get the items
        if (isset($limit))
        {
            $objArticles = \NewsModel::findPublishedByPids($this->news_archives, $blnFeatured, $limit, $offset, $arrOptions);
        }
        else
        {
            $objArticles = \NewsModel::findPublishedByPids($this->news_archives, $blnFeatured, 0, $offset, $arrOptions);
        }

        // Add the articles
        if ($objArticles !== null)
        {
            $this->Template->articles = $this->parseArticles($objArticles);
        }

        $this->Template->archives = $this->news_archives;
    }

}

