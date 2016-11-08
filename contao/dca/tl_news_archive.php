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

$GLOBALS['TL_DCA']['tl_news_archive']['palettes']['default'] .= ';{simplify_legend},simplify,simplify_news_teaser';


$GLOBALS['TL_DCA']['tl_news_archive']['fields']['simplify'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_news_archive']['simplify'],
    'inputType'               => 'checkbox',
    'sql'                     => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_news_archive']['fields']['simplify_news_teaser'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_news_archive']['simplify_news_teaser'],
    'inputType'               => 'checkbox',
    'sql'                     => "char(1) NOT NULL default ''"
];

