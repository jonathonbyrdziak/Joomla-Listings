<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: view.feed.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage reservation
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 * This component file was created using the Joomla Component Creator by Not Web Design
 * http://www.notwebdesign.com/joomla_component_creator/
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

/**
 * Feed View class for the reservation component
 */
class ByrdlistViewListings extends ResView 
{
	/**
	 * Contains the table model to use
	 * 
	 * @var string
	 */
	var $_table = 'byrdlist_listings';
	
	/**
	 * 
	 */
	function display($tpl = null) 
	{
        parent::display($tpl);
    }
    
    /**
     * Search Results Loop
     * 
     */
    protected function search_result( $path = null )
    {
    	//loading resources
    	$db =& JFactory::getDBO();
    	
    	//initializing variables
    	$data = JRequest::get('get');
    	$geo = $this->getGeoPostal( $data['postal_code'] );
    	
    	if (!$data['postal_code'] || !$data['distance'])
    	{
    		$query = "SELECT * FROM `#__byrdlist_listings` as `listings`"
	    		." WHERE `listings`.`published` = '1'"
	    		." AND (`listings`.`name` LIKE '%".trim($data['filter'])."%'"
	    		." OR `listings`.description LIKE '%".trim($data['filter'])."%')"
	    		." LIMIT 0,5";
    	}
	    else
	    {
			$query = "SELECT id, ( 3959 * acos( cos( radians(".$geo['lattitude'].") ) * cos( radians( `listings`.`lattitude` ) ) * cos( radians( `listings`.`longitude` ) - radians(".$geo['longitude'].") ) + sin( radians(".$geo['lattitude'].") ) * sin( radians( `listings`.`lattitude` ) ) ) ) AS distance "
	    		." FROM `#__byrdlist_listings` as `listings`"
	    		." WHERE `listings`.`published` = '1'"
	    		." AND (`listings`.`name` LIKE '%".trim($data['filter'])."%'"
	    		." OR `listings`.description LIKE '%".trim($data['filter'])."%')"
	    		." HAVING distance < ".$data['distance']." ORDER BY distance"
	    		." LIMIT 0,5";
	    }
	    
	    $db->setQuery( $query );
    	$results = $db->loadAssocList();
	    
    	//reasons to fail
		if (!$results) return false;
		
		foreach ($results as $result)
    	{
    		$instance = JTable::getInstance($this->_table, 'Table');
    		
    		//reasons to continue
    		if (!$instance->load( $result['id'] )) continue;
    		
    		$listings[$result['id']] = $instance;
    	}
    	
    	$listings = ByrdHelper::sort_object($listings, 'created_on');
    	
    	foreach ($listings as $id => $record)
    	{
    		//loading resources
    		$thumb =& $record->thumbnail();
    		
    		require $path;
    	}
    	
    	return true;
    }
    
    /**
     * Get the Geo location for the given postal code
     * 
     */
    protected function getGeoPostal( $postal = null )
    {
    	//initializing variables
		$url = 'http://maps.google.com/maps/api/geocode/json?address='.urlencode($postal).'&sensor=false';
		
		//loading resources
		$data = @file_get_contents($url);
		
		//reasons to fail
		if (!($json = json_decode($data))) return false;
		if ($json->status != "OK") return false;
		if (!isset($json->results[0])) return false;
		
		
		//initializing variables
		$results = array();
		$results['lattitude'] = $json->results[0]->geometry->location->lat;
		$results['longitude'] = $json->results[0]->geometry->location->lng;
		
		return $results;
    }
    
    /**
     * Just for deleting images via ajax
     * 
     */
    protected function new_two_editthumbnail()
    {
    	//initializing variables
    	$data = JRequest::get('get');
    	
    	$record =& JTable::getInstance('byrdlist_images', 'Table');
    	$record->load( $data['id'] );
    	$record->setThumbnail();
    	
    	echo $record->id();
    	
    	exit();
    	return true;
    }
    
    /**
     * Just for deleting images via ajax
     * 
     */
    protected function new_two_setthumbnail()
    {
    	//initializing variables
    	$data = JRequest::get('get');
    	
    	$record =& JTable::getInstance('byrdlist_images', 'Table');
    	$record->load( $data['id'] );
    	$record->setThumbnail();
    	
    	echo $record->id();
    	
    	exit();
    	return true;
    }
    
    /**
     * Just for deleting images via ajax
     * 
     */
    protected function new_two_deleteimage()
    {
    	//initializing variables
    	$data = JRequest::get('get');
    	
    	$record =& JTable::getInstance('byrdlist_images', 'Table');
    	$record->load( $data['id'] );
    	
    	echo $record->id();
    	
    	$record->delete();
    	
    	exit();
    	return true;
    }
    
    
}
?>