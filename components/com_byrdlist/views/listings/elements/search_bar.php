<?php
/**
 * Joomla! 1.5 component reservation
 *
 * @version $Id: view.html.php 2010-06-02 12:34:25 svn $
 * @author 
 * @package Joomla
 * @subpackage Listings
 * @license Copyright (c) 2010 - All Rights Reserved
 *
 * 
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//initializing variables
$media = "components/".EBOOK_COMPONENT."/media/";

//loading media
JHTML::Script('searchbar.js', $media.'js/');

?>
<div class="search_wrapper">
	<div class="search_container">
		<div class="search_settings">
			<form action="?option=com_byrdlist&view=listings" id="basic_search" method="post">
				<div class="search_left"></div>
				<div class="search_mid">
					<div class="mid_top">
						<b>Find</b>
						<input type="text" id="filter" name="search_filter" onKeyUp="javascript: _search();" />
						<!-- 
						<b>in</b>
						<select id="select_categories" name="_categories_id">
							<option></option>
						</select>
						 -->
						<div class="mbutton">
							<a href="#" onClick="javascript: _get('basic_search').submit();" class="">Go</a>
						</div>
					</div>
					<div class="mid_bottom">
						<b>Zip Code</b>
						<input type="text" id="postal_code" name="postal_code" class="postal_code" onKeyUp="javascript: _search();" />
						
						<b>Distance</b> <small>(in miles)</small>
						<label>25
							<input type="radio" value="25" class="search_distance" name="distance" onChange="javascript: _search();" />
						</label>
						<label>50
							<input type="radio" value="50" class="search_distance" name="distance" onChange="javascript: _search();" />
						</label>
						<label>100
							<input type="radio" value="100" class="search_distance" name="distance" onChange="javascript: _search();" />
						</label>
						<label>Any
							<input type="radio" value="0" class="search_distance" name="distance" onChange="javascript: _search();" />
						</label>
					</div>
				</div>
				<div class="search_right"></div>
			</form>
		</div>
		<div class="results_container">
			<div class="search_results" id="search_results">
				<div class="clearfix"></div>
			</div>
			<div class="results_footer"></div>
		</div>
	</div>
</div>