<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2015 Leo Feyer
 *
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2012-2015 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    simplify
 * @license    LGPL
 * @filesource
 */


$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist'] = str_replace(',skipFirst', ',skipFirst,simplify_sorting',
    $GLOBALS['TL_DCA']['tl_module']['palettes']['newslist']);

$GLOBALS['TL_DCA']['tl_module']['fields']['simplify_sorting'] = array
(
		'label'                   => &$GLOBALS['TL_LANG']['tl_module']['simplify_sorting'],
		'exclude'                 => true,
		'inputType'               => 'select',
		'options_callback'        => array('tl_module_simplify_sorted_news', 'getSortingOptions'),
		'reference'               => &$GLOBALS['TL_LANG']['tl_module']['sorting_options'],
		'eval'                    => array('tl_class'=>'w50'),
		'sql'                     => "varchar(16) NOT NULL default ''"
);


class tl_module_simplify_sorted_news extends Backend {
	
	public function getSortingOptions() {
		
		$this->loadLanguageFile('tl_news');

		$attribs = ['headline','date','author','subheadline'];
		$options = [''  => '-'];
		foreach($attribs as $a) {
			$options[$a.'_asc']  = $GLOBALS['TL_LANG']['tl_news'][$a][0].' '.$GLOBALS['TL_LANG']['tl_module']['simplify_sorting_asc'];
			$options[$a.'_desc'] = $GLOBALS['TL_LANG']['tl_news'][$a][0].' '.$GLOBALS['TL_LANG']['tl_module']['simplify_sorting_desc'];
		}

		$options['random'] = $GLOBALS['TL_LANG']['tl_module']['simplify_sorting_random'];
		return $options;		
	}
}
