<?php 
/**
 * @author      Jonathon Byrd
 * @package     Joomla!
 * 
 */

//security  
defined('_JEXEC') or die('Restricted access'); 

/**
 * Create Html DOM
 * @author Jonathon Byrd
 * 
 */
class CreateHtmlDom extends JObject
{
	/**
	 * Build me a Drop down
	 * 
	 * Method will build a drop down using html and return the html as a string
	 * 
	 * @param $dropdown
	 */
	function build( $array, $name = null, $default = null )
	{
		//initialize variables
		$id = $name;
		$html = '<select name="'.$id.'" id="'.$id.'">';
		
		foreach ($array as $value => $option)
		{
			//determining the selected option
			$selected = "";
			if (!is_null($default))
			{
				if ($default == $value) $selected = "selected";
			}
			
			//build the options
			$html .= '<option value="'.$value.'" '.$selected.'>'.$option.'</option>';
		}
		
		$html .= '</select>';
		
		return $html;
	}
	
	
}