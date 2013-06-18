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
	$GLOBALS['TL_DCA']['tl_calendar_events']['list']['operations']['editheader']['href'];
 
// Remove metadata button
unset($GLOBALS['TL_DCA']['tl_calendar_events']['list']['operations']['editheader']);

// Show text in backend row
$GLOBALS['TL_DCA']['tl_calendar_events']['list']['sorting']['child_record_callback'] =
	array('tl_calendar_events_simplify', 'listEvents');

} // END if...

class tl_calendar_events_simplify extends tl_calendar_events {
	
	public function listEvents($arrRow) {
        $key     = (strlen($arrRow['teaser']) > 0) ? 'teaser' : 'text';
        $excerpt = String::substr($arrRow[$key], 72);

        $format = $GLOBALS['TL_CONFIG']['dateFormat'];
        $start  = Date::parse($format, $arrRow['startDate']);
		$end    = (strlen($arrRow['endDate']) == 0 || $arrRow['endDate'] == $arrRow['startDate']) ? '' : ' - '.Date::parse($format, $arrRow['endDate']);

        $time  = '';
		if ($arrRow['addTime']) {
            $startTime = Date::parse($GLOBALS['TL_CONFIG']['timeFormat'], $arrRow['startTime']);
            $endTime   = Date::parse($GLOBALS['TL_CONFIG']['timeFormat'], $arrRow['endTime']);

            if ($startTime == $endTime) {
                // only startTime
                $start .= '&nbsp;'.$startTime;
            }
            else {
                $time = '&nbsp;'.$startTime.'-'.$endTime;
            }
		}

		return '<div class="tl_content_left"><strong>' . $arrRow['title'] . '</strong> <span style="color:#b3b3b3;padding-left:3px">[' . $start . $end . $time . ']</span><br>'.
			$excerpt.'</div>';
	}

	
}

