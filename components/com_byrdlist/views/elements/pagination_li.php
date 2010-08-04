<?php defined('_JEXEC') or die('Restricted access'); ?>


<?php if ($is_page): ?>
	<li><?php echo $i; ?></li>
	
<?php elseif ($before < $i && $i < $after): ?>
	<li>
		<strong>
			<a href="?option=com_byrdlist<?php echo $view.$layout.$task.$categories_id.$search; ?>&limitstart=<?php echo $limitstart; ?>" title="<?php echo $i; ?>">
			<?php echo $i; ?></a>
		</strong>
	</li>
	
<?php endif; ?>