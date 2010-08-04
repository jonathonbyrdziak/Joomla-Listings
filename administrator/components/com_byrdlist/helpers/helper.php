<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: helper.php 2010-06-02 12:34:25 svn $
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

/**
 * reservation Helper
 *
 * @package Joomla
 * @subpackage reservation
 * @since 1.5
 */
class ByrdHelper 
{
	/**
	 * Get the Sugar Id From the Joomla Id
	 * 
	 */
	public function getSugarId( $id = null )
	{
		//loading resources
		$db =& JFactory::getDBO();
		
		//Get the Contacts information
		$query = "SELECT `id_c` "
				." FROM `contacts_cstm`"
				." WHERE `joomla_user_id_c` = '$id'";
		
		$db->setQuery( $query );
		$result = $db->loadAssoc( );
		
		//reasons to return
		if (!$result) return false;
		
		return $result['id_c'];
	}
	
	/**
	 * HAS NOT BEEN TESTED
	 * IS NOT BEING USED YET
	 * 
	 */
	public static function multisort($array, $sort_by, $key1=NULL, $key2=NULL, $key3=NULL, $key4=NULL, $key5=NULL, $key6=NULL)
	{
		// sort by ?
		foreach ($array as $pos =>  $val)
			$tmp_array[$pos] = $val[$sort_by];
		
		asort($tmp_array);
		
		// display however you want
		foreach ($tmp_array as $pos =>  $val)
		{
			$return_array[$pos][$sort_by] = $array[$pos][$sort_by];
			$return_array[$pos][$key1] = $array[$pos][$key1];
			if (isset($key2))
			{
				$return_array[$pos][$key2] = $array[$pos][$key2];
			}
			if (isset($key3))
			{
				$return_array[$pos][$key3] = $array[$pos][$key3];
			}
			if (isset($key4))
			{
				$return_array[$pos][$key4] = $array[$pos][$key4];
			}
			if (isset($key5))
			{
				$return_array[$pos][$key5] = $array[$pos][$key5];
			}
			if (isset($key6))
			{
				$return_array[$pos][$key6] = $array[$pos][$key6];
			}
		}
		return $return_array;
	}
	
	/**
	 * Redesigned to sort object arrays
	 * 
	 */
	public static function sort_object($array, $sort_by, $desc = true)
	{
		//reasons to return
		if (is_object($array)) return $array;
		if (!is_array($array)) return $array;
		if (empty($array)) return $array;
		
		//initializing variables
		$tmp_array = array();
		$return_array = array();
		
		// sort by ?
		foreach ($array as $pos => $val)
			$tmp_array[$pos] = $val->$sort_by;
		
		asort($tmp_array);
		if ($desc) $tmp_array = array_reverse($tmp_array, true);
		
		
		// display however you want
		foreach ($tmp_array as $pos =>$val)
		{
			$return_array[$pos] = $array[$pos];
			
			//$return_array[$pos][$sort_by] = $array[$pos][$sort_by];
			//$return_array[$pos][$key1] = $array[$pos][$key1];
		}
		return $return_array;
	}
	
}

?>