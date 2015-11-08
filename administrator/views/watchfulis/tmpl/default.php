<?php if(!$this->installed): ?>
	<?php echo $this->notInstalledMsg; ?>
<?php else : ?>
	<?php if(!$this-apikey): ?>
		<p>You have not entered an API Key for this vendor</p>
	<?php else : ?>
		<?php echo $this->html; ?>
		<script>
			jQuery(document).ready( function (){
				ko.applyBindings(new viewModel('<?php echo $this->apikey;?>'), jQuery('#reportContainer')[0]);
			})
		</script>
	<?php endif; ?>	
<?php endif; ?>
