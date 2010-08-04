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

//loading media
JHTML::script('ajaxupload.js', 'components/'.EBOOK_COMPONENT.'/media/js/');


//initializing variables
$relpath = '/administrator/components/'.EBOOK_COMPONENT.'/libraries/uploads/';


?>
<style type="text/css"> iframe { display:none; } </style>

<div id="listing"> 
	<h2>
		<?php echo $this->_record->name(); ?>
		<div style="position:relative;float:right;">
			<div class="mbutton"> 
				<a href="?option=com_byrdlist&view=myaccount" rel="nofollow">
				Back to the My Account</a>
			</div>
		</div>
	</h2>
	
	<div class="column first">
		<?php echo $this->_record->description(); ?>
		
		<br/>
		<br/>
		<hr style="width:95%;border:1px solid #555;" />
		
		<form name="writeMessageForm" class="composeForm" id="writeMessageForm" 
		action="" method="post"> 
		
		<table border="0" cellpadding="3" cellspacing="0" width="100%">
		
		<?php $this->element('new_two_type_fields'); ?>
		
		<tr> 
			<td class="mbutton"> 
				
				<a href="#" onClick="javascript: isValid( 'writeMessageForm' ); return false;" rel="nofollow">
				Submit</a>
				
				<a href="?option=com_byrdlist&view=authors&layout=new&record=<?php echo $this->_record->id(); ?>" rel="nofollow">
				Back</a>
				
				<?php if ($this->_record->isNew()): ?>
				<a href="?option=com_byrdlist&view=myaccount" rel="nofollow">
				Cancel</a>
				<?php else: ?>
				<a href="?option=com_byrdlist&view=authors&layout=details&record=<?php echo $this->_record->id(); ?>" rel="nofollow">
				Cancel</a>
				<?php endif; ?>
			
			</td> 
		</tr> 
			
		</table> 
		
		<input type="hidden" name="expired" value="0" />
		<input type="hidden" name="record" value="<?php echo $this->id; ?>" />
		<input type="hidden" name="id" value="<?php echo $this->id; ?>" />
		<input type="hidden" name="option" value="com_byrdlist" /> 
		<input type="hidden" name="view" value="authors" /> 
		<input type="hidden" name="layout" value="details" /> 
		<input type="hidden" name="task" value="save" /> 
		<input type="hidden" name="Itemid" value="<?php echo JRequest::getVar('Itemid'); ?>" />
		
		</form>
	</div>
	
	<div class="column second">
		<form action="?option=com_byrdlist&view=listings&format=ajax&layout=ajaxupload" method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
			<input type="hidden" name="_websites_id" value="<?php echo $this->id; ?>" /> 
			<input type="hidden" id="imageform_id" name="id" value="" />
			<input type="hidden" name="published" value="1"/>
			
			<div class="rating-fav">
				<h4>Choose an Image to upload</h4>
				<div class="favourite mbutton" style="margin-bottom:8px;">
					<input type="file" id="file_name" name="file_name" />
				</div>
				
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption"><b>Name:</b></span> 
					<div id="fav-count">
						<input type="text" id="inputboxname" class="inputbox" name="name" value="" style="width:320px;" /> 
					</div>
				</div>
				
				<div class="favourite" style="margin-bottom:5px;">
					<span class="fav-caption"><b>Description:</b></span> 
					<div id="fav-count">
						<textarea id="inputboxdescription" name="description" style="width:325px;height:60px;padding:3px;"></textarea>
					</div>
				</div>
				
				<div class="favourite mbutton" style="margin-bottom:2px;">
					<a href="#" onClick="javascript: ajaxUpload(thisform,thisform.action,'upload_area','File Uploading Please Wait...','Error in Upload, check settings and path info in source code.'); return false;" rel="nofollow">
					Upload Image</a>
				</div>
				
			</div>
		</form>
		
		<h3>Images</h3>
		<div class="fields" id="parent_upload_area">
			
			<div class="row0">
				<div class="fieldRow lastFieldRow" style="width:98%" id="upload_area">
					<!-- Images Uploaded here :: id="upload_area" -->
				</div>
			</div>
			
			<?php if (is_array($this->images) && !empty($this->images)): ?>
				<?php foreach ($this->images as $id => $record): ?>
					<div class="row0" id="<?php echo $record->id(); ?>">
						<div class="fieldRow lastFieldRow" style="width:98%">
						
							<span class="imageactions"> 
								<?php if (!$record->isThumbnail()): ?>
									<span id="<?php echo $record->id(); ?>_span">
										<a href="#" onClick="javascript: _thumb('<?php echo $record->id(); ?>'); return false;">
										thumbnail | </a>
									</span>
								<?php endif; ?>
								<span>
									<a href="#" onClick="javascript: _delete('<?php echo $record->id(); ?>'); return false;">
									delete | </a> 
									<!-- 
									<a href="#" onClick="javascript: _edit('<?php echo $record->id(); ?>'); return false;">
									edit</a>
									 -->
								</span>
							</span>
							<img src="<?php echo $record->file(); ?>" border="0" width="75px" align="left" style="margin-right:10px;"/>
							<b><?php echo $record->name(); ?></b><br/>
							<span style="font-size:10px;"><?php echo substr($record->description(),0,120); ?></span>
							
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<script src="<?php echo DOTCOM; ?>components/<?php echo EBOOK_COMPONENT; ?>/media/js/new_two.js"></script>