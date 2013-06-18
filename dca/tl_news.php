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

// Add featured_stop field


$GLOBALS['TL_DCA']['tl_news']['fields']['featured_stop'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['featured_stop'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
    'sql'                     => "varchar(10) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] =
    str_replace(',featured' , ',featured,featured_stop', $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);

$GLOBALS['TL_DCA']['tl_news']['fields']['cssClass']['eval'] = array('tl_class' => 'w50');
$GLOBALS['TL_DCA']['tl_news']['fields']['noComments']['eval']['tl_class'] = 'w50 m12';
$GLOBALS['TL_DCA']['tl_news']['fields']['featured']['eval']['tl_class']   = 'w50 m12';

$GLOBALS['TL_DCA']['tl_news']['list']['operations']['feature']['button_callback'] = array('tl_news_simplify', 'iconFeatured');

$GLOBALS['TL_DCA']['tl_news']['config']['onsubmit_callback'][] = array('tl_news_simplify', 'checkFeaturedStop');

if (array_key_exists('simplify_news', $GLOBALS['TL_CONFIG']) && $GLOBALS['TL_CONFIG']['simplify_news'] === true) {

$GLOBALS['TL_DCA']['tl_news']['config']['ctable']       = false;
$GLOBALS['TL_DCA']['tl_news']['config']['switchToEdit'] = false;

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

} // END if ...


class tl_news_simplify extends tl_news {

    public function listNewsArticles($arrRow) {
		$key     = (strlen($arrRow['teaser']) > 0) ? 'teaser' : 'text';
		$excerpt = String::substr($arrRow[$key], 72);

        $featured_stop_info = '';
        if ($arrRow['featured_stop'] != '') {
            $featured_stop_info = ', <strong>'.sprintf($GLOBALS['TL_LANG']['tl_news']['featured_till'], Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], $arrRow['featured_stop'])).'</strong>';
        }

		return '<div class="tl_content_left"><strong>' . $arrRow['headline'] . '</strong> <span style="color:#b3b3b3;padding-left:3px">[' . Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], $arrRow['date']) . $featured_stop_info.']</span><br>'.
			$excerpt.'</div>';
	}

    public function iconFeatured($row, $href, $label, $title, $icon, $attributes) {

        if ($row['featured_stop'] == '' || $row['featured_stop'] > time()) {
            return parent::iconFeatured($row, $href, $label, $title, $icon, $attributes);
        }

        $icon  = 'featured_.gif';
        $title = sprintf($GLOBALS['TL_LANG']['tl_news']['featured_disabled'], Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], $row['featured_stop']));
        return '<a href="'.$this->addToUrl('').'" onclick="Backend.getScrollOffset();alert(\''.$title.'\');return false;" title="'.specialchars($title).'">'.Image::getHtml($icon, $label).'</a> ';

    }

    public function checkFeaturedStop() {
        $this->import('Simplify');
        $this->Simplify->checkFeaturedStop();
    }

}





