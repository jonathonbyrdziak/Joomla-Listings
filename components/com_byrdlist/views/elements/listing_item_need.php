<?php defined('_JEXEC') or die('Restricted access'); ?>

	<div class="listing-summary"> 
		<div class="header"> 
			<h3>
			<?php if (!$record->isClosed()): ?>
				<?php if ($this->is_owner): ?>
				<a href="?option=com_byrdlist&view=listings&layout=new&record=<?php echo $record->id(); ?>" 
				class="actionlink">
				Edit</a>
				<?php endif; ?>
			<?php endif; ?>
			
			<a style="font-size:22px;color:#555;text-decoration:none;"
			href="?option=com_byrdlist&view=listings&layout=details&record=<?php echo $record->id(); ?>">
			<?php echo $record->name(); ?></a>
			</h3>
			
			( <a style="font-size:10px;letter-spacing:1px;text-decoration:none;color:blue;padding:3px;"
			href="?option=com_byrdlist&view=listings&layout=details&record=<?php echo $record->id(); ?>#reviews">
			<?php echo $record->countComments(); ?> Comments</a> )
			
			<div class="column">
			Availability :: <?php echo date('Y-m-d', strtotime($record->auction_end( 1 ))); ?>
			</div>
		</div>
		
		<?php if ( $thumbnail ): ?>
			<a href="?option=com_byrdlist&view=listings&layout=details&record=<?php echo $record->id(); ?>">
			<img border="0" src="<?php echo $thumbnail; ?>" 
			width="100" class="image-left" alt="Joomla!" />
			</a>
		<?php endif; ?>
		
		<p class="address">
		<?php foreach ($tags as $id => $tag): ?>
			<?php if (strlen(trim($id)) <1) continue; ?>
			<a class="tag" href="?option=com_byrdlist&view=listings&layout=search&for=<?php echo urlencode($tag->name()); ?>">
			<?php echo $tag->name(); ?></a>, 
		<?php endforeach; ?>
		</p>
		
		<p class="website">
		<?php if ( $record->website() ): ?>
			<a style="text-decoration:none;padding:3px;font-size:10px;letter-spacing:1px;"
			href="http://<?php echo str_replace('http://','', $record->website()); ?>" target="_blank">
			<?php echo $record->website(); ?></a>
		<?php endif; ?>
		</p>
		
		<p>
		<?php echo substr($record->description(),0,500); ?><b>...</b>
		</p>
		
		<div class="fields"></div>
		
	</div>