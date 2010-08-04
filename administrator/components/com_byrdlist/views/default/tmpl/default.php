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

$this->element('toolbar_default'); 
JToolBarHelper::title('Listings', 'generic.png'); 

?>
<div id="element-box"> 
	<div class="t"> 
		<div class="t"> 
			<div class="t"></div> 
		</div> 
	</div> 
	<div class="m"> 
		<form action="index.php?option=com_byrdlist&view=default" method="post" name="adminForm">
		
			<!-- 
			<table> 
				<tr> 
					<td width="100%"> 
						Filter:
						<input type="text" name="search" id="search" value="" class="text_area" onchange="document.adminForm.submit();" title="Filter by Title or enter an Article ID"/> 
						<button onclick="this.form.submit();">Go</button> 
						<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_sectionid').value='-1';this.form.getElementById('catid').value='0';this.form.getElementById('filter_authorid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();">Reset</button> 
					</td> 
					<td nowrap="nowrap"> 
						<select name="filter_sectionid" id="filter_sectionid" class="inputbox" size="1" onchange="document.adminForm.submit();">
						<option value="-1"  selected="selected">- Select Section -</option>
						<option value="0" >- Uncategorised -</option>
						<option value="2" >Idozo</option>
						<option value="7" >MyBlog</option>
						<option value="6" >Categories</option>
						</select>
						
						<select name="catid" id="catid" class="inputbox" size="1" onchange="document.adminForm.submit();">
						<option value="0"  selected="selected">- Select Category -</option>
						<option value="3" >Company Information</option>
						<option value="14" >MyBlog</option>
						<option value="12" >Type</option>
						<option value="13" >Other</option>
						</select>
						
						<select name="filter_authorid" id="filter_authorid" class="inputbox" size="1" onchange="document.adminForm.submit( );">
						<option value="0"  selected="selected">- Select Author -</option>
						<option value="63" >David Lower</option>
						<option value="62" >Jonathon Byrd</option>
						<option value="64" >Nicholas Horlocker</option>
						<option value="65" >vinny bansal</option>
						</select>
						
						<select name="filter_state" id="filter_state" class="inputbox" size="1" onchange="submitform( );">
						<option value=""  selected="selected">- Select State -</option>
						<option value="P" >Published</option>
						<option value="U" >Unpublished</option>
						<option value="A" >Archived</option>
						</select>
					</td> 
				</tr> 
			</table> 
			  -->
  
		<table class="adminlist" cellspacing="1"> 
			<thead> 
				<tr> 
					<th width="5"> 
						#
					</th> 
					<th width="5"> 
						<input type="checkbox" name="toggle" value="" onclick="checkAll(20);" /> 
					</th> 
					<th class="title"> 
						<a href="javascript:tableOrdering('c.title','desc','');" 
						title="Click to sort by this column">
							Name <img src="/administrator/images/sort_asc.png" alt=""  /></a>
					</th> 
					<th class="title" width="10%"> 
						<a href="javascript:tableOrdering('c.title','desc','');" 
						title="Click to sort by this column">
							Type <img src="/administrator/images/sort_asc.png" alt=""  /></a>
					</th>
					<th class="title" width="12%" nowrap="nowrap"> 
						<a href="javascript:tableOrdering('section_name','desc','');" 
						title="Click to sort by this column">
							Published
						</a>
					</th>
					<th class="title" width="10%" nowrap="nowrap"> 
						<a href="javascript:tableOrdering('author','desc','');" 
						title="Click to sort by this column">
							Author <img src="/administrator/images/sort_asc.png" alt=""  /></a>	
					</th> 
					<th align="center" width="10"> 
						<a href="javascript:tableOrdering('c.created','desc','');" 
						title="Click to sort by this column">
							Date <img src="/administrator/images/sort_asc.png" alt=""  /></a>
					</th>
					<th width="13%" class="title"> 
						<a href="javascript:tableOrdering('c.id','desc','');" 
						title="Click to sort by this column">
							ID</a>
					</th> 
				</tr> 
			</thead> 
			<tfoot> 
			<tr> 
				<td colspan="15"> 
					<?php $this->element('pagination'); ?>	
				</td> 
			</tr> 
			</tfoot> 
			<tbody> 
				<?php $this->element('default_listings'); ?>	
			</tbody> 
		</table> 
		<table cellspacing="0" cellpadding="4" border="0" align="center"> 
		<tr align="center"> 
			<td> 
			<img src="images/publish_y.png" width="16" height="16" border="0" alt="Pending" /> 
			</td> 
			<td> 
			Published, but is <u>Pending</u> |
			</td> 
			<td> 
			<img src="images/publish_g.png" width="16" height="16" border="0" alt="Visible" /> 
			</td> 
			<td> 
			Published and is <u>Current</u> |
			</td> 
			<td> 
			<img src="images/publish_r.png" width="16" height="16" border="0" alt="Finished" /> 
			</td> 
			<td> 
			Published, but has <u>Expired</u> |
			</td> 
			<td> 
			<img src="images/publish_x.png" width="16" height="16" border="0" alt="Finished" /> 
			</td> 
			<td> 
			Not Published |
			</td> 
			<td> 
			<img src="images/disabled.png" width="16" height="16" border="0" alt="Archived" /> 
			</td> 
			<td> 
			Archived
			</td> 
		</tr> 
		<tr> 
			<td colspan="10" align="center"> 
			Click on icon to toggle state.
			</td> 
		</tr> 
		</table> 
		
		<input type="hidden" name="option" value="<?php echo EBOOK_COMPONENT; ?>" /> 
		<input type="hidden" name="task" value="" /> 
		<input type="hidden" name="boxchecked" value="0" /> 
		<input type="hidden" name="redirect" value="-1" /> 
		<input type="hidden" name="filter_order" value="section_name" /> 
		<input type="hidden" name="filter_order_Dir" value="" /> 
		<input type="hidden" name="268c00c407c7e10d7a5164d447cd9018" value="1" />
	</form> 
		
				<div class="clr"></div> 
			</div> 
			<div class="b"> 
				<div class="b"> 
					<div class="b"></div> 
				</div> 
			</div> 
   		</div> 
		<noscript> 
			Warning! JavaScript must be enabled for proper operation of the Administrator back-end.
		</noscript> 
		<div class="clr"></div>