function reloadDom (key, data)
{
	ko.cleanNode( jQuery('#watchfullIDataContainer')[0]);
	ko.applyBindings(new view(key, data), jQuery('#watchfullIDataContainer')[0])
}

var view = function (key, data)
{
	var self = this;
	this.apiKey = key;
	this.hasLoaded = ko.observable((data) ? true: false);
	this.siteId = localStorage.getItem('siteId') || null;
	this.site = ko.observable(data || null);
	this.name = ko.observable()
	this.dateBackup = ko.observable()
	this.date_last_check = ko.observable()
	this.admin_url = ko.observable()
	this.canUpdate = ko.observable()
	this.jUpdate = ko.observable()

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
						//self.site(sites[i]);
						for(var key in sites[i])
						{
							try {
								self[key](sites[i][key]);
							} catch (e){}
						}
						localStorage.setItem('siteId', sites[i].siteid);
						self.hasLoaded(true);
						return;
					}
				}
				alert('Your site is not registered with Watchfull I')
			}
		})
	}

	function getSiteDashboard ()
	{
		if(!data) {
			jQuery.ajax({
				url: 'https://watchful.li/api/v1/sites/'+self.siteId+'?api_key='+self.apiKey,
				method: 'GET',
				success: function (res)
				{
					for(var key in res.msg)
					{
						try {
							self[key](res.msg[key]);
						} catch (e){}
					}
					self.hasLoaded(true);
				}
			})
		}
	}

	function __construct ()
	{
		if(self.siteId == null)
		{
			return __getSiteId();
		}
		return getSiteDashboard();
	}
	__construct();

}
var viewExt = function (key, data)
{
	var self = this;
	this.apiKey = key
	this.hasLoaded = ko.observable((data) ? true: false);
	this.siteId = localStorage.getItem('siteId') || null;
	this.extensions = ko.observableArray();

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
						localStorage.setItem('siteId', sites[i].siteid);
						self.siteId = sites[i].siteid
						return getExtensionsList();
					}
				}
				alert('Your site is not registered with Watchfull I')
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
				console.log(res)
				var exts = res.msg.data;
				for(var i = 0; i < exts.length; i++)
				{
					exts[i].vUpdate = ko.observable(exts[i].vUpdate);
				}
				self.extensions(exts)
				self.hasLoaded(true);
			}
		})
	}

	function __construct (data)
	{
		if(self.siteId == null)
		{
			return __getSiteId();
		}
		if(!data){
			return getExtensionsList();
		}
	}
	__construct(data);

}
