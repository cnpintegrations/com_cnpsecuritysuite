var viewModel = function (key)
{
	var self = this;
	this.apiKey = key;
	this.dashLoaded = ko.observable(false);
	this.extLoaded = ko.observable(false);
	this.siteId = localStorage.getItem('siteId') || null;
	this.name = ko.observable()
	this.dateBackup = ko.observable()
	this.date_last_check = ko.observable()
	this.admin_url = ko.observable()
	this.canUpdate = ko.observable()
	this.jUpdate = ko.observable()
	this.j_version = ko.observable()
	this.new_j_version = ko.observable();
	this.extensions = ko.observableArray();

	this.updateReportTitle = ko.computed(function ()
	{
		return window.location.host.toUpperCase()+" Update Report "+ new Date().toLocaleDateString();
	})

	this.securityRisk = ko.computed(function ()
	{
		var numberOfRisks = self.extensions().length;
		numberOfRisks += self.jUpdate();
		var message;
		if( numberOfRisks == 0)
		{
			message = "<p>SECURED: Site is safe.</p>";
		}
		else if(numberOfRisks <= 6)
		{
			message = "<p>CAUTION: Site Will need work.</p>"
		} else if (numberOfRisks <= 12) {
			message = "<p>NEEDS ATTENTION: Security Risk.</p>"
		} else {
			message = "<p>SITES AT RISK: Site Needs to be attended too.</p>"
		}

		message += "See global security threats in real time: <a href='http://map.norsecorp.com/'>Live Attack Map</a>"
		return message;
	})

	this.nextSteps = ko.computed( function (){
		var numberOfRisks = self.extensions().length;
		numberOfRisks += self.jUpdate();
		var message;
		if( numberOfRisks == 0)
		{
			message = "<p>You site is secured, check back again in a few weeks.</p>";
		}
		else if(numberOfRisks <= 6)
		{
			message = "<p>Please contact <a href='cnpintegrations.com'> CNP Integrations</a> for a two hour initial assesment.</p>"
		} else if (numberOfRisks <= 12) {
			message = "<p>Please contact <a href='cnpintegrations.com'> CNP Integrations</a> for a four hour initial assesment.</p>"
		} else {
			message = "<p>Please contact <a href='cnpintegrations.com'> CNP Integrations</a> for a four hour initial assesment. May require more time.</p>"
		}

		return message;
	});

	function __getSiteId ()
	{
		jQuery.ajax({
			url: 'https://watchful.li/api/v1/sites/',
			method: 'GET',
			data: {api_key: self.apiKey},
			success: function (res)
			{
				var sites = res.msg.data;
				for(var i = 0; i < sites.length; i++)
				{
					var url = sites[i].access_url;
					url.replace('www.', '');
					if(url.indexOf(window.location.origin) > -1)
					{
						for(var key in sites[i])
						{
							try {
								self[key](sites[i][key]);
							} catch (e){}
						}
						localStorage.setItem('siteId', sites[i].siteid);
						self.dashLoaded(true);
						return getExtensionsList();
					}
				}
				alert('Your site is not registered with Watchfull I')
			}
		})
	}

	function getSiteDashboard ()
	{
		jQuery.ajax({
			url: 'https://watchful.li/api/v1/sites/'+self.siteId+'?api_key='+self.apiKey,
			method: 'GET',
			success: function (res)
			{
				console.log("dash Board");
				console.log(res.msg);
				for(var key in res.msg)
				{
					try {
						self[key](res.msg[key]);
					} catch (e){}
				}
				self.dashLoaded(true);
			}
		})
	}

	function getExtensionsList ()
	{
		jQuery.ajax({
			url: 'https://watchful.li/api/v1/extensions',
			method: 'GET',
			data: {api_key: self.apiKey, siteids: self.siteId, vUpdate: 1},
			success: function (res)
			{
				console.log("Extensions");
				console.log(res.msg.data);
				var exts = res.msg.data;
				for(var i = 0; i < exts.length; i++)
				{
					exts[i].vUpdate = ko.observable(exts[i].vUpdate);
					exts[i].currentVersion = ko.observable(exts[i].version);
					exts[i].targetVersion = ko.observable(exts[i].newVersion)
				}
				self.extensions(exts)
				self.extLoaded(true);
			}
		})
	}

	function __construct ()
	{
		if(self.siteId == null)
		{
			return __getSiteId();
		}
		getExtensionsList();
		return getSiteDashboard();
	}
	__construct();

	this.updateJoomla = function ()
	{
		return jQuery.ajax({
			url: 'https://watchful.li/api/v1/sites/'+self.siteId+'/updatejoomla',
			method: 'POST',
			data: {api_key: self.apiKey},
			success: function (res)
			{
				window.location.reload();
			}
		})
	}

	self.akeebaBackup = function ()
	{
		return jQuery.ajax({
			url: 'https://watchful.li/api/v1/sites/'+self.siteId+'/backupstart',
			method: 'POST',
			data: {api_key: self.apiKey},
			success: function (res)
			{
				window.location.reload();
			}
		})
	}

	self.updateExtension = function (ext)
	{
		return jQuery.ajax({
			url: 'https://watchful.li/api/v1/extensions/'+ext.id_ext+'/update?api_key='+self.apiKey,
			method: 'POST',
			success: function (res)
			{
				console.log(res);
				ext.vUpdate(0);
			}
		})
	}
}
