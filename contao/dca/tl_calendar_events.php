<?php

/**
 *
 * Contao extension simplify
 *
 * @copyright  Martin Kozianka 2012-2015 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    simplify
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_calendar_events']['config']['onload_callback'][] = ['tl_calendar_events_simplify', 'adjustDca'];

use Contao\CalendarModel;

class tl_calendar_events_simplify extends tl_calendar_events {

    public function adjustDca($dc)
    {
        $objCal = CalendarModel::findByPk($dc->id);
        if ($objCal !== null && $objCal->simplify === '1')
        {
            $list = &$GLOBALS['TL_DCA']['tl_calendar_events']['list'];

            // Change link in edit button
            $list['operations']['edit']['href'] = $list['operations']['editheader']['href'];

            // Remove metadata button
            unset($list['operations']['editheader']);

            // Show text in backend row
            $list['sorting']['child_record_callback'] = ['tl_calendar_events_simplify', 'listEvents'];
        }
    }

    public function listEvents($arrRow)
    {
        $strResult = parent::listEvents($arrRow);

        $key       = (strlen($arrRow['teaser']) > 0) ? 'teaser' : 'text';
        $excerpt   = '<br><span>'.StringUtil::substr($arrRow[$key], 72).'</span></div>';

        $pos       = strrpos($strResult, '</div>');
        $strResult = ($pos !== false) ? substr_replace($strResult, $excerpt, $pos, strlen('</div>')) : $strResult;

        // Small addon for plugin contao-fussball (https://github.com/kozi/contao-fussball)
        $cssClass = 'tl_content_left simplify';
        if (array_key_exists('fussball_matches_id', $arrRow))
        {            
            $cssClass .= ($arrRow['fussball_matches_id']    !== '0') ? ' fussball_event fussball_matches':'';
            $cssClass .= ($arrRow['fussball_tournament_id'] !== '0') ? ' fussball_event fussball_tournament':'';
            $strResult = str_replace('tl_content_left', $cssClass, $strResult);
        }

        return $strResult;
	}
	
}
