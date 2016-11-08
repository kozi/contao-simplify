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

$tlNews = &$GLOBALS['TL_DCA']['tl_news'];

// Add featured_stop field
$tlNews['fields']['featured_stop'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['featured_stop'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'],
    'sql'                     => "varchar(10) NOT NULL default ''"
];

// Add text field
$tlNews['fields']['text'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['text'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'textarea',
    'eval'                    => ['rte'=>'tinyMCE', 'tl_class'=>'clr'],
    'sql'                     => "text NULL"
];

$tlNews['palettes']['default'] = str_replace(',featured' , ',featured,featured_stop', $tlNews['palettes']['default']);

$tlNews['config']['onload_callback'][]                      = ['tl_news_simplify', 'adjustDca'];
$tlNews['config']['onsubmit_callback'][]                    = ['tl_news_simplify', 'checkFeaturedStop'];
$tlNews['config']['onsubmit_callback'][]                    = ['tl_news_simplify', 'checkFeaturedStop'];
$tlNews['list']['operations']['feature']['button_callback'] = ['tl_news_simplify', 'iconFeatured'];

$tlNews['fields']['cssClass']['eval']                       = ['tl_class' => 'w50'];
$tlNews['fields']['noComments']['eval']['tl_class']         = 'w50 m12';
$tlNews['fields']['featured']['eval']['tl_class']           = 'w50 m12';

use Contao\NewsArchiveModel;
use Contao\NewsModel;
use ContaoSimplify\Simplify;

class tl_news_simplify extends tl_news
{

    public function listNewsArticles($arrRow)
    {
		$key     = (strlen($arrRow['teaser']) > 0) ? 'teaser' : 'text';
		$excerpt = StringUtil::substr($arrRow[$key], 72);

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
        Simplify::checkFeaturedStop();
    }

    public function adjustDca($dc)
    {
        $objArchive = NewsArchiveModel::findByPk($dc->id);
        if ($objArchive === null) {

            $objNews = NewsModel::findByPk($dc->id);
            if ($objNews !== null) {
                $objArchive = NewsArchiveModel::findByPk($objNews->pid);
            }
        }

        if ($objArchive !== null && $objArchive->simplify === '1')
        {
            $tlNews = &$GLOBALS['TL_DCA']['tl_news'];

            $tlNews['config']['ctable']       = false;
            $tlNews['config']['switchToEdit'] = false;

            // Change link in edit button
            $tlNews['list']['operations']['edit']['href'] = $tlNews['list']['operations']['editheader']['href'];

            // Remove editheader button
            unset($tlNews['list']['operations']['editheader']);

            if ($objArchive->simplify_news_teaser === '1')
            {
                // Add text field to default palette
                $tlNews['palettes']['default'] = str_replace(
                    '{teaser_legend},subheadline,teaser;',
                    '{teaser_legend},subheadline,teaser;{text_legend},text;',
                    $tlNews['palettes']['default']);
            }
            else
            {
                $tlNews['fields']['teaser']['label'] = $GLOBALS['TL_LANG']['tl_news']['text'];
            }

            // Show text in backend row
            $tlNews['list']['sorting']['child_record_callback'] = ['tl_news_simplify', 'listNewsArticles'];
        }
    }

}
