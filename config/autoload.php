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
ClassLoader::addNamespace('Simplify');

ClassLoader::addClasses(array(
	'Simplify\ModuleNewsSortedList'    => 'system/modules/simplify/classes/ModuleNewsSortedList.php',
	'Simplify\Simplify'                => 'system/modules/simplify/classes/Simplify.php',
));

/*
TemplateLoader::addFiles(array(

));
*/