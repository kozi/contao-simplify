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

$GLOBALS['TL_DCA']['tl_calendar']['palettes']['default'] .= ';{simplify_legend},simplify';


$GLOBALS['TL_DCA']['tl_calendar']['fields']['simplify'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_calendar']['simplify'],
    'inputType'               => 'checkbox',
    'sql'                     => "char(1) NOT NULL default ''"
];
