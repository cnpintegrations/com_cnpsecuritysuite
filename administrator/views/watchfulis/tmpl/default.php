<h1 class='text-center'><i class='fa fa-wrench'></i> Watchfull I Admin Dashboard</h1>
<hr>
<?php if($this->installed == false): ?>
	<p>The Watchfuli Component is not currently installed or enabled, please contact CNP Integrations in order to add this
	protective security measure to your site and learn more about what may happen if your site isn't watched.</p>
<?php else : ?>
<script>
	ko.applyBindings(new viewExt('<?php echo $this->apikey;?>'), jQuery('#watchfullIDataContainer2')[0])
	ko.applyBindings(new view('<?php echo $this->apikey;?>'), jQuery('#watchfullIDataContainer')[0])
</script>

<div class='row-fluid' id='watchfullIDataContainer'>
	<div class='span12 text-center'>
		<div data-bind='visible: hasLoaded() == false' class='unloaded-data'>
			<i class="fa fa-spinner fa-spin fa-5x"></i>
			<br>
			<br>
			<p>Loading ...</p>
		</div>
		<div class='loaded-data text-center row-fluid' data-bind='visible: hasLoaded() == true'>
			<div class='well well-small'>
			<h2 class='module-title nav-header' data-bind='text: name()+" Watchfull Info"'></h2>
			<div class='row-striped'>
				<div class='row-fluid'>
					<div class='span9'>
						<p data-bind='text: "Last Akeeba backup date"'></p> 
					</div>
					<div class='span3'>
						<span class='small'>
							<span class='icon-calendar'></span>
							<p data-bind='text: dateBackup()'></p>
						</span>
					</div>
				</div>
				<div class='row-fluid'>
					<div class='span9'>
						<p> Last Akeeba Backup Scan </p>
					</div>
					<div class='span3'>
						<span class='small'>
							<span class='icon-calendar'></span>
							<p data-bind='text: date_last_check()'></p>
						</span>
					</div>
				</div>
				<div class='row-fluid'>
					<div class='span9'>
						<p> Start Akeeba Backup of your site </p>
					</div>
					<div class='span3'>
						<a data-bind='event: {click: akeebaBackup}' class='btn btn-primary'> Back Up Site</a>
					</div>
				</div>
				<div class='row-fluid'>
					<div class='span9'>
						<p>Available Extension Updates?</p> 
					</div>
					<div class='span3'>
						<!-- ko if: canUpdate() == 1 -->
						<a data-bind='attr: {href: admin_url()+"?option=com_installer&view=update"}' class='btn btn-primary'> Yes! <i class='fa fa-check'></i></a>
						<!-- /ko -->
						<p data-bind='visible: canUpdate() != 1, text: "No"'></p>
					</div>
				</div>
				<div class='row-fluid'>
					<div class='span9'>
						<p>  Available Joomla Update? </p>
					</div>
					<div class='span3'>
						<!-- ko if: jUpdate() == 1 -->
						<a data-bind='event: {click: updateJoomla}' class='btn btn-primary'> Yes, and Update Joomla! <i class='fa fa-check'></i></a>
						<!-- /ko -->
						<p data-bind='visible: jUpdate() != 1, text: "No"'></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class='row-fluid' id='watchfullIDataContainer2'>
	<div class='span12 text-center'>
		<div class='loaded-data text-center row-fluid' data-bind='visible: hasLoaded() == true'>
			<div class='well well-small'>
				<h2 class='module-title nav-header' data-bind='text: "Extensions to Update"'></h2>
				<div class='row-striped' data-bind='foreach: extensions'>
					<div class='row-fluid'>
						<div class='span9'>
							<p data-bind='text: ext_name'></p> 
						</div>
						<div class='span3'>
							<i class='fa fa-check' data-bind='visible: vUpdate() == 0'></i>
							<button class='btn btn-primary' data-bind='visible: vUpdate() == 1, event: {click: $root.updateExtension}'>Update</button>
						</div>
					</div>
				</div>
				<p>*** Unupdated Joomla! extensions are a security risk for your website. If you are unable to update an extension or would like
				more information, please contact CNPIntegrations at <a href='mailto:support@cnpintegrations.com'>support@cnpintegrations.com</a> ***</p>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>
