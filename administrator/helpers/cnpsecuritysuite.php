<?php

/**
 * @version     1.0.0
 * @package     com_cnpsecuritysuite
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Tyler Oliver <tyler@cnpintegrations.com> - http://www.cnpintegrations.com
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Cnpsecuritysuite helper.
 */
class CnpsecuritysuiteHelper {

    public static function getNotInstalledMsg ($name)
    {
        return "<p>The ".$name." Component is not currently installed or enabled, please contact your Joomla! provider in order to add this ".
        "protective security measure to your site and learn more about what may happen if your site isn't watched.</p>";
    }

    public static function getNorseAttackMsg ()
    {
        return "<p>See global web security threats in real time: <a href='http://map.norsecorp.com/'>Live Attack Map</a></p>";
    }
    /**
    *   Gets the Vendors key and name from data base by ID
    */

    public static function getVendor ($id)
    {
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);
 
        // Create the base select statement.
        $query->select('*')
                ->from($db->quoteName('#__cnpsecuritysuite_keys'))
                ->where($db->quoteName('id') . ' = '. $db->quote($id));
        $db->setQuery($query);
 
        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        return (isset($results[0]->apikey)) ? $results[0] : null;
    }

    /**
    *   Returns the HTML file associated with the plugin
    */
    public static function getHtml($plugin)
    {
        return file_get_contents(JPATH_ADMINISTRATOR .'/components/com_cnpsecuritysuite/assets/plugins/'.$plugin.'.html');
    }

    /**
    *   loadScripts for the component with an optional plugin prefix to load the plugins javaScript file
    */
    public static function loadScripts($plugin = null)
    {
        $document = JFactory::getDocument();
     
        //stylesheets
        $document->addStylesheet(JURI::base().'components/com_cnpsecuritysuite/assets/css/font-awesome.min.css');
     
        //javascripts
        $document->addScript(JURI::base().'components/com_cnpsecuritysuite/assets/js/knockout.js');
    
        if(isset($plugin))
        {
            $document->addScript(JURI::base().'components/com_cnpsecuritysuite/assets/plugins/'.$plugin.'.js');
        }
    }

    /**
    *   Check if component is installed
    */
    public static function isInstalled($component)
    {
        if(is_dir(JPATH_ADMINISTRATOR . '/components/com_'.$component) && JComponentHelper::isEnabled('com_'.$component, true))
        {
            return true;
        }
        return false;
    }

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_CNPSECURITYSUITE_TITLE_SETTINGSS'),
			'index.php?option=com_cnpsecuritysuite&view=settingss',
			$vName == 'settingss'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_CNPSECURITYSUITE_TITLE_WATCHFULIS'),
			'index.php?option=com_cnpsecuritysuite&view=watchfulis',
			$vName == 'watchfulis'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_CNPSECURITYSUITE_TITLE_PINGDOMS'),
			'index.php?option=com_cnpsecuritysuite&view=pingdoms',
			$vName == 'pingdoms'
		);
		JHtmlSidebar::addEntry(
			"My Joomla",
			"https://myjoomla.com/");
		JHtmlSidebar::addEntry(
			"Sites Assure",
			"http://www.sitesassure.com/");
		JHTMLSidebar::addEntry(
			'Run Akeeba Backup',
			'index.php?option=com_akeeba&view=backup'
		);
		JHTMLSidebar::addEntry(
			'Web Security Attack Map',
			'http://map.norsecorp.com/'
		);
    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_cnpsecuritysuite';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}
