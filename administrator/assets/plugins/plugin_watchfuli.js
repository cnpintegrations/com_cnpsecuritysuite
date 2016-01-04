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
			message = "<p>SAFE: Site is secured but will need future work.</p>"
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
			message = "<p>Your site is secured, check back again in a few weeks.</p>";
		}
		else if(numberOfRisks <= 6)
		{
			message = "<p>Your site is secured however it is recommened to contact your Joomla! provider for an assessment</p>"
		} else if (numberOfRisks <= 12) {
			message = "<p>Your site is in an unsafe state. Please contact your Joomla! provider in order to secure your data.</p>"
		} else {
			message = "<p>Your sites safety is in danger. It is highly recommended to contact your Joomla! provider before your site gets hacked or infected.</p>"
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
			}, error: function (res)
			{
				alert("Invalid API Key for Watchfulli")
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
			}, error: function (res)
			{
				alert("Invalid API Key for Watchfulli")
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
			}, error: function (res)
			{
				alert("Invalid API Key for Watchfulli")
			}
		})
	}
}
