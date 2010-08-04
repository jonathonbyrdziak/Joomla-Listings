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
JHTML::script('image_click.js', 'components/'.EBOOK_COMPONENT.'/media/js/');

?>

<style>
a.publishbutton:hover{background-color:pink !important;}
a.publishbutton{background-color:red !important;}
</style>
	
<a name="bidhere"></a>
<div id="listing">
	<?php if (!$this->_record->published() && !$this->_record->isClosed()): ?>
		<br/><span class="warning">In order for users to view your listing, click on the PUBLISH button below.</span><br/><br/><br/>
	<?php endif; ?>
	
	<h2>
		<?php if ($this->is_owner): ?>
			<?php if (!$this->_record->published()): ?>
				<a href="?option=com_byrdlist&view=authors&layout=details&task=publish&record=<?php echo $this->_record->id(); ?>" 
				class="actionlink publishbutton">PUBLISH</a>
			<?php else: ?>
				<a href="?option=com_byrdlist&view=authors&layout=details&task=unpublish&record=<?php echo $this->_record->id(); ?>" 
				class="actionlink">UN-PUBLISH</a>
			<?php endif; ?>
			
			<a href="?option=com_byrdlist&view=authors&layout=new&record=<?php echo $this->_record->id(); ?>" 
			class="actionlink">Edit</a>
			
			<a href="?option=com_byrdlist&view=authors&layout=details&task=delete&record=<?php echo $this->_record->id(); ?>"
			class="actionlink"">Delete</a>
		<?php endif; ?>
		
		<?php echo $this->_record->name(); ?>
		
		<div style="position:relative;float:right;">
			<div class="mbutton">
				<?php if ($this->isLoggedIn): ?>
					<a href="?option=com_byrdlist&view=myaccount" rel="nofollow">
					My Account</a>
				<?php endif; ?>
				
				<a href="?option=com_byrdlist&view=authors" rel="nofollow">
				Back to Non profit Webpage Listings</a>
			</div>
		</div>
	</h2> 
 
	<div class="column first">
		<div class="listing-desc">
			<?php echo $this->_record->description(); ?>
		</div>
		
	</div>
	
	<div class="column second">
		<div class="images"> 
			<div class="content">
			<?php if (is_array($this->_record->images())): ?>
				<?php foreach ($this->_record->images() as $id => $instance): $count++; ?>
					<?php if (!$instance->file()) { $instance->delete(); continue; } ?>
					
					<?php if ($count == 1): ?>
						<div class="thumbnail first">
							<a id="mainimagelink" href="#" onClick="javascript: return false;">
							<img id="mainimage" src="<?php echo $instance->file(); ?>" 
							alt="<?php echo $this->_record->name(); ?>" style="width:380px" />
							</a>
						</div>
					<?php else: ?>
						<div class="thumbnail-left">
							<a href="#" onClick="javascript: return _imageClick( this );">
							<img id="_image_<?php echo $count; ?>" src="<?php echo $instance->file(); ?>" alt="<?php echo $this->_record->name(); ?>"
							 style="width:120px;" />
							</a>
						</div>
					<?php endif; ?>
					
				<?php endforeach; ?>
			<?php endif; ?>
			</div>
		</div> 
	</div>
	
	<?php if ($this->_record->published()): ?>
	<div class="actions-rating-fav">
		<div class="mbutton" style="padding:10px;">
			<?php foreach ($this->_record->getWebpages() as $id => $instance): ?>
				<a href="?option=com_byrdlist&view=authors&layout=details&record=<?php echo $instance->id(); ?>" rel="nofollow">
				<?php echo $instance->name(); ?></a>
			<?php endforeach; ?>
			
			<?php if ($this->is_owner): ?>
				<a href="?option=com_byrdlist&view=authors&layout=new" rel="nofollow">
				Add New Page</a>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
</div>