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
$list = array(
	'0' => ' -- No -- '
);

$query = "SELECT * FROM `#__byrdlist_listings` as `listings`"
		." WHERE `listings`.`published` = '1'"
		." AND `listings`.`type` = 'financial'"
		." ORDER BY `listings`.`created_on` ASC"
		;
		
		
//loading resources
$db =& JFactory::getDBO();
$db->setQuery( $query );
$results = $db->loadAssocList();

if ($results)
{
	foreach ($results as $result)
   	{
   		$instance = JTable::getInstance($this->_table, 'Table');
   		
   		//reasons to continue
   		if (!$instance->load( $result['id'] )) continue;
   		if ($instance->isClosed()) continue;
   		
   		$list[$result['id']] = $instance->name();
   	}
}

echo CreateHtmlDom::build( $list, '_financial_id', $this->_record->availability() );
?>
