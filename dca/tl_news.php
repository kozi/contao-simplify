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

if (array_key_exists('simplify_news', $GLOBALS['TL_CONFIG']) && $GLOBALS['TL_CONFIG']['simplify_news'] === true) {

// Change link in edit button
$GLOBALS['TL_DCA']['tl_news']['list']['operations']['edit']['href'] =
	$GLOBALS['TL_DCA']['tl_news']['list']['operations']['editheader']['href'];
 
// Remove editheader button
unset($GLOBALS['TL_DCA']['tl_news']['list']['operations']['editheader']);

// Add text field
$GLOBALS['TL_DCA']['tl_news']['fields']['text']          = $GLOBALS['TL_DCA']['tl_news']['fields']['teaser'];
$GLOBALS['TL_DCA']['tl_news']['fields']['text']['label'] = $GLOBALS['TL_LANG']['tl_news']['text'];


if (array_key_exists('simplify_news_teaser', $GLOBALS['TL_CONFIG']) && $GLOBALS['TL_CONFIG']['simplify_news_teaser'] === true) { 
	// Add text field to default palette
	$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace(
		'{teaser_legend},subheadline,teaser;',
		'{teaser_legend},subheadline,teaser;{text_legend},text;',
		$GLOBALS['TL_DCA']['tl_news']['palettes']['default']);
}
else {
	$GLOBALS['TL_DCA']['tl_news']['fields']['teaser']['label'] = $GLOBALS['TL_LANG']['tl_news']['text'];
}


// Show text in backend row
$GLOBALS['TL_DCA']['tl_news']['list']['sorting']['child_record_callback'] =
	array('tl_news_simplify', 'listNewsArticles');


class tl_news_simplify extends tl_news {

	public function listNewsArticles($arrRow) {
		$key     = (strlen($arrRow['teaser']) > 0) ? 'teaser' : 'text';
		$excerpt = String::substr($arrRow[$key], 72);

		return '<div class="tl_content_left"><strong>' . $arrRow['headline'] . '</strong> <span style="color:#b3b3b3;padding-left:3px">[' . $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $arrRow['date']) . ']</span><br>'.
			$excerpt.'</div>';
	}

}

} // END if ... 



