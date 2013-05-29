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
if (array_key_exists('simplify_calendar_events', $GLOBALS['TL_CONFIG']) && $GLOBALS['TL_CONFIG']['simplify_calendar_events'] === true) {
	
// Change link in edit button
$GLOBALS['TL_DCA']['tl_calendar_events']['list']['operations']['edit']['href'] =
	$GLOBALS['TL_DCA']['tl_calendar_events']['list']['operations']['editmeta']['href'];
 
// Remove metadata button
unset($GLOBALS['TL_DCA']['tl_calendar_events']['list']['operations']['editmeta']);

// Change label for teaser text
// $GLOBALS['TL_LANG']['tl_calendar_events']['teaser'] = $GLOBALS['TL_LANG']['tl_calendar_events']['text'];


// Show text in backend row
$GLOBALS['TL_DCA']['tl_calendar_events']['list']['sorting']['child_record_callback'] =
	array('tl_calendar_events_simplify', 'listEvents');


class tl_calendar_events_simplify extends tl_calendar_events {
	
	public function listEvents($arrRow) {
		$excerpt = String::substr($arrRow['teaser'], 72);
		return '<div class="tl_content_left"><strong>' . $arrRow['title'] . '</strong> <span style="color:#b3b3b3;padding-left:3px">[' . $this->parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $arrRow['date']) . ']</span><br>'.
			$excerpt.'</div>';
	}

	
}

} // END if...