<?php defined('_JEXEC') or die('Restricted access'); ?>

<a name="reviews"></a>

<div class="reviews"> 
	<div class="title" style="font-weight:bold;font-size:16px !important;color:#555;">
		<?php if ($this->_record->type() == 'need'): ?>
			Offers (<?php echo $countComments; ?>)
		<?php elseif ($this->_record->type() == 'donation') : ?>
			Requests (<?php echo $countComments; ?>)
		<?php else : ?>
			Comments (<?php echo $countComments; ?>)
		<?php endif; ?>
	</div> 
	
	<?php if ($countComments >0) : ?>
	
		<?php $this->element('comments_item'); ?>
		
		<?php if (!$this->_record->isClosed()): ?>
			<p class="mbutton">
				<?php if ($this->_record->type() == 'need'): ?>
				<a href="?option=com_byrdlist&view=listings&layout=offer&_listings_id=<?php echo $this->_record->id(); ?>">
					Submit an Offer
				<?php elseif ($this->_record->type() == 'donation') : ?>
					<?php if (!$this->user->isDonor() ): ?>
					<a href="?option=com_byrdlist&view=listings&layout=request&_listings_id=<?php echo $this->_record->id(); ?>">
					Submit a Request
					<?php endif; ?>
				<?php else : ?>
				<a href="?option=com_byrdlist&view=listings&layout=comment&_listings_id=<?php echo $this->_record->id(); ?>">
					Submit Comment
				<?php endif; ?>
				<span class="lucida button-arrow"></span>
				</a> 
			</p>
		<?php endif; ?>
		
	<?php else : ?>
		
		<?php if (!$this->_record->isClosed()): ?>
			<p class="mbutton">
				<?php if ($this->_record->type() == 'need'): ?>
				<a href="?option=com_byrdlist&view=listings&layout=offer&_listings_id=<?php echo $this->_record->id(); ?>">
					Be the first to submit an Offer!
				<?php elseif ($this->_record->type() == 'donation') : ?>
				<a href="?option=com_byrdlist&view=listings&layout=request&_listings_id=<?php echo $this->_record->id(); ?>">
					Be the first to submit a Request!
				<?php else : ?>
				<a href="?option=com_byrdlist&view=listings&layout=comment&_listings_id=<?php echo $this->_record->id(); ?>">
					Be the first to review this listing!
				<?php endif; ?>
				<span class="lucida button-arrow"></span>
				</a> 
			</p> 
		<?php endif; ?>
	
	<?php endif; ?>
</div>