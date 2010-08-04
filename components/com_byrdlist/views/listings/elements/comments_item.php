<?php defined('_JEXEC') or die('Restricted access'); ?>

<div class="review" style="margin-left:<?php echo $margin_left; ?>px;">
		<div class="review-head">
		
			<div class="review-info">
				<?php if ($is_reply): ?>
					<p class="review-date">Reply to: <?php echo $record->parent_name(); ?></p>
				<?php endif; ?>
				
				by
				<span class="review-owner">
					<?php echo $record->author_name(); ?>
				</span>
				<p class="review-date">December 24, 2009</p> 
			</div>
			
			<?php if (!$this->isRequest): ?>
				<div id="rhc7" class="found-helpful">
					<span id="rh7"> 
					<?php echo $record->helpful(); ?> of <?php echo $record->helpful_total(); ?> 
					people found this review helpful 
					</span>
				</div>
				
			<?php endif; ?>
		</div>
		
		<div class="review-text">
			<div class="review-title">
				<!-- 
				<?php for ($i = 1; $i <= 5; $i++) :?>
					<?php if ($i <= $record->rating()): ?>
						<img src="administrator/components/com_byrdlist/views/media/star_10.png" width="16" height="16" hspace="1" alt="" />
					<?php else: ?>
						<img src="administrator/components/com_byrdlist/views/media/star_00.png" width="16" height="16" hspace="1" alt="" />
					<?php endif; ?>
				<?php endfor; ?>
				 -->
				 
				<h4><?php echo $record->name(); ?></h4>
				
			</div> 
			
			<?php echo $record->description(); ?>
		</div> 
		
		<?php if (!$is_helpful && !$this->isClosed && !$comment_owner): ?>
		<div class="ask-helpful">
			<div class="ask-helpful2" id="ask7">
				Was this review helpful to you?
			</div>
			
			<span id="rhaction7" class="rhaction">
				<a href="?option=com_byrdlist&view=listings&layout=details&record=<?php echo $this->_record->id(); ?>&helpful=<?php echo $record->id(); ?>">
				Yes</a>
				&nbsp;&nbsp;
				<a href="?option=com_byrdlist&view=listings&layout=details&record=<?php echo $this->_record->id(); ?>&helpful_no=<?php echo $record->id(); ?>">
				No</a>
			</span>
		</div>
		<?php endif; ?>
		
		<div class="review-reply-and-report">
			<?php if (!$this->user->isDonor()): ?>
				<?php if (!$this->isClosed): ?>
					<?php if ($this->is_owner): ?>
					
						<?php if ( $this->isRequest && !$record->isAwarded() && $record->_comments_children == 0 ): ?>
						<div class="review-report">
							<a href="?option=com_byrdlist&view=listings&layout=details&task=award&record=<?php echo $this->_record->id(); ?>&id=<?php echo $record->id(); ?>" 
							class="actionlink">Award</a>
						</div>
						<?php endif; ?>
					
					<?php elseif (!$comment_owner): ?>
						<div class="review-report">
							<a href="?option=com_byrdlist&view=listings&layout=report&_listings_id=<?php echo $this->_record->id(); ?>&_comments_id=<?php echo $record->id(); ?>" class="actionlink">
							Report</a>
						</div>
					<?php endif; ?>
					
					<div class="review-reply">
						<a href="?option=com_byrdlist&view=listings&layout=comment&_listings_id=<?php echo $this->_record->id(); ?>&parent_id=<?php echo $record->id(); ?>" class="actionlink">
						Reply</a>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div> 
		