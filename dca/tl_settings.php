<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2013 Leo Feyer
 *
 *
 * PHP version 5
 * @copyright  Martin Kozianka 2011-2013 <http://kozianka.de/>
 * @author     Martin Kozianka <http://kozianka.de/>
 * @package    simplify
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{simplify_legend},simplify_news,simplify_news_teaser,simplify_calendar_events,simplify_calendar_events_teaser';

$GLOBALS['TL_DCA']['tl_settings']['fields']['simplify_news'] = array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['simplify_news'],
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class'=>'w50 m12')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['simplify_news_teaser'] = array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['simplify_news_teaser'],
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class'=>'w50 m12')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['simplify_calendar_events'] = array(
		'label'		              => &$GLOBALS['TL_LANG']['tl_settings']['simplify_calendar_events'],
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class'=>'w50 m12')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['simplify_calendar_events_teaser'] = array(
		'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['simplify_calendar_events_teaser'],
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class'=>'w50 m12')
);


