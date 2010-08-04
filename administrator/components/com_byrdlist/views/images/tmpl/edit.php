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

//Title and Toolbar
JToolBarHelper::title('Images :: Add/Edit', 'generic.png'); 
$this->element('toolbar_edit'); 

JRequest::setVar( 'hidemainmenu', 1 );


?>

	<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data"> 
 
		<div class="col width-60"> 
			<fieldset class="adminform"> 
				<legend>Details</legend> 
 
					<table class="admintable"> 
					<tr> 
						<td class="key"> 
							<label for="title" width="100"> 
								Title:
							</label> 
						</td> 
						<td colspan="2"> 
							<input class="text_area" type="text" name="name" id="name" 
							value="<?php echo $this->_record->name(); ?>" 
							size="50" maxlength="50" title="A long name to be displayed as the page 
							heading when this field is set to Show." /> 
						</td> 
					</tr> 
					<tr> 
						<td class="key"> 
							<label for="alias"> 
								Image File:
							</label> 
						</td> 
						<td colspan="2"> 
							<input class="text_area" type="file" name="file_name" id="file_name" 
							value="" size="50" maxlength="255" title="<?php echo $this->_record->file_name(); ?>" /> 
						</td> 
					</tr> 
					<tr> 
						<td width="120" class="key"> 
							Published:
						</td> 
						<td> 
							<input type="radio" name="published" id="published0" value="0" class="inputbox" 
							<?php echo (!$this->_record->published())? 'checked="checked"':""; ?> /> 
							<label for="published0">No</label> 
							
							<input type="radio" name="published" id="published1" value="1" class="inputbox"
							<?php echo ($this->_record->published())? 'checked="checked"':""; ?> /> 
							<label for="published1">Yes</label> 
						</td> 
					</tr> 
					<tr> 
						<td class="key" colspan="2"> 
							<?php if ($this->_record->file()): ?>
								<img src="/administrator/<?php echo $this->_record->file(); ?>" />
							<?php endif; ?>
						</td> 
					</tr> 
					<tr> 
						<td class="key"> 
							Listing:
						</td> 
						<td>
							<?php $this->element('select_listings'); ?>
						</td> 
					</tr>
				</table> 
			</fieldset> 
 
			<fieldset class="adminform"> 
				<legend>Description</legend> 
 
				<table class="admintable"> 
					<tr> 
						<td valign="top" colspan="3"> 
							<div id="jce_editor_description_toggle"></div>
							<textarea id="description" name="description" cols="60" rows="20" 
							style="width:550px; height:300px;" class="mceEditor"><?php echo $this->_record->description(); ?></textarea> 
 
							<div id="editor-xtd-buttons"> 
								<div class="button2-left">
									<div class="image">
										<a class="modal-button" title="Image" 
										href="?option=com_media&amp;view=images&amp;tmpl=component&amp;e_name=description"  
										rel="{handler: 'iframe', size: {x: 570, y: 400}}">
										Image</a>
									</div>
								</div> 
							</div> 
							<script type="text/javascript">function jceOnLoad(){JContentEditor.initEditorMode('description');}</script>
						</td> 
					</tr> 
				</table> 
				
			</fieldset> 
		</div> 
		<div class="clr"></div> 
 		
 		<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
		<input type="hidden" name="option" value="<?php echo EBOOK_COMPONENT; ?>" />
		<input type="hidden" name="view" value="images" />
		<input type="hidden" name="layout" value="edit" />
		<input type="hidden" name="oldtitle" value="<?php echo $this->_record->name(); ?>" /> 
		<input type="hidden" name="id" value="<?php echo $this->_record->id(); ?>" /> 
		<input type="hidden" name="record" value="<?php echo $this->_record->id(); ?>" /> 
		<input type="hidden" name="task" value="" /> 
		<input type="hidden" name="redirect" value="<?php echo EBOOK_COMPONENT; ?>" /> 
		<input type="hidden" name="268c00c407c7e10d7a5164d447cd9018" value="1" />
	</form>