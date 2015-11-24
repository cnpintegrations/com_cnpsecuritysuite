<?php if (!$this->installed) : ?>
	<p>The Pingdom Component is not currently installed or enabled, please contact CNP Integrations in order to add this
	protective security measure to your site and learn more about what may happen if your site isn't watched.</p>
<?php else : ?>
	<h2>Pingdom - To be completed</h2>
	<?php if(!$this-apikey): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div class='span10'>
		<p>You have not entered an API Key for this vendor</p>
	</div>
	<?php else : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div class='span10'>
		<?php echo $this->html; ?>
	</div>
	<?php endif; ?>
<?php endif; ?>

<script>
</script>
