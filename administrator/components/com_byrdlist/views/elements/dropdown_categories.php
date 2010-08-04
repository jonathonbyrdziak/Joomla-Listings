<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: reservation.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage reservation
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

require_once EBOOK_EVERY.DS.'dom'.DS.'create_html_dom.php';

//initializing variables
$record =& JTable::getInstance('byrdlist_categories', 'Table');
$list = $record->getList();
$array = array('' => ' -- Top level -- ');

if (is_array($list))
{
	foreach ($list as $id => $object)
	{
		if ($id == $this->_record->id()) continue;
		$array[$id] = $object->name();
	}
}

echo CreateHtmlDom::build( $array, 'parent_id', $this->_record->parent_id());
?>
