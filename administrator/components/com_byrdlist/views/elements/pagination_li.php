<?php defined('_JEXEC') or die('Restricted access'); ?>


<?php if ($is_page): ?>
	<span><?php echo $i; ?></span>
	
<?php elseif ($before < $i && $i < $after): ?>
	<a href="#" title="<?php echo $i; ?>" onclick="javascript: document.adminForm.limitstart.value=<?php echo $limitstart; ?>; submitform();return false;"><?php echo $i; ?></a> 

<?php endif; ?>