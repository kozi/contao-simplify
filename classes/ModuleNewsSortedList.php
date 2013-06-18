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
 * Class ModuleNewsSortedList
 *
 * 
 * @copyright  Martin Kozianka 2012-2013 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    simplify
 */
class ModuleNewsSortedList extends \ModuleNewsList {

	public function generate() {
		if (TL_MODE == 'BE') {
			return str_replace('### NEWS LIST ###', '### NEWS SORTED LIST '.$this->news_sorting.'###', parent::generate());
		}
		return parent::generate();
	}
	
	/**
	 * Generate the module
	 */
	protected function compile()
	{
		$offset = intval($this->skipFirst);
		$limit = null;
		$this->Template->articles = array();

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

		// Get the total number of items
		$intTotal = \NewsModel::countPublishedByPids($this->news_archives, $blnFeatured);

		if ($intTotal < 1)
		{
			$this->Template->articles = array();
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

			// Overall limit
			if ($offset + $limit > $total)
			{
				$limit = $total - $offset;
			}

			// Add the pagination menu
			$objPagination = new \Pagination($total, $this->perPage, 7, $id);
			$this->Template->pagination = $objPagination->generate("\n  ");
		}

		// Sorting
		if ($this->simplify_sorting == 'random') {
			$order = 'RAND()';
		}
		else {
			$order = 'tl_news.'.str_replace(array('_asc' ,'_desc'), array(' ASC', ' DESC'), $this->simplify_sorting);
		}
		$arrOptions = array('order' => $order);

		// Get the items
		if (isset($limit))
		{
			$objArticles = \NewsModel::findPublishedByPids($this->news_archives, $blnFeatured, $limit, $offset, $arrOptions);
		}
		else
		{
			$objArticles = \NewsModel::findPublishedByPids($this->news_archives, $blnFeatured, 0, $offset, $arrOptions);
		}

		// No items found
		if ($objArticles === null)
		{
			$this->Template = new \FrontendTemplate('mod_newsarchive_empty');
		}
		else
		{
			$this->Template->articles = $this->parseArticles($objArticles);
		}

		$this->Template->archives = $this->news_archives;
		$this->Template->empty    = $GLOBALS['TL_LANG']['MSC']['emptyList'];
	}

}

