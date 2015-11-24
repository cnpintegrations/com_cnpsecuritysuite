<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id='j-main-container' class='span10 j-toggle-main'>
	<?php if (!$this->installed) : ?>
		<p>The Pingdom Component is not currently installed or enabled, please contact CNP Integrations in order to add this
		protective security measure to your site and learn more about what may happen if your site isn't watched.</p>
	<?php else : ?>
		<h2>Pingdom - To be completed</h2>
		<?php if(!$this-apikey): ?>
			<p>You have not entered an API Key for this vendor</p>
		<?php else : ?>
			<?php echo $this->html; ?>
		<?php endif; ?>
	<?php endif; ?>

	<script>
	</script>
</div>
