<h1 class='text-center'><i class='fa fa-wrench'></i> Watchfull I Admin Dashboard</h1>
<hr>
<?php if(!$this->installed): ?>
	<p>The Watchfuli Component is not currently installed or enabled, please contact CNP Integrations in order to add this
	protective security measure to your site and learn more about what may happen if your site isn't watched.</p>
<?php else : ?>
	<?php if(!$this-apikey): ?>
		<p>You have not entered an API Key for this vendor</p>
	<?php else : ?>
		<script>
			ko.applyBindings(new viewExt('<?php echo $this->apikey;?>'), jQuery('#watchfullIDataContainer2')[0])
			ko.applyBindings(new view('<?php echo $this->apikey;?>'), jQuery('#watchfullIDataContainer')[0])
		</script>
	<?php endif; ?>
	<?php echo $this->html; ?>
<?php endif; ?>
