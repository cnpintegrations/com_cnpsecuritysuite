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

    public static function loadScripts($page = null)
    {
        $document = JFactory::getDocument();
     
        //stylesheets
        $document->addStylesheet(JURI::base().'components/com_cnpsecuritysuite/assets/css/font-awesome.min.css');
     
        //javascripts
        $document->addScript(JURI::base().'components/com_cnpsecuritysuite/assets/js/knockout.js');

        switch($page)
        {
            case "watchfuli":
                $document->addScript(JURI::base().'components/com_cnpsecuritysuite/assets/js/watchfuli.js');
                break;
            case "pingdom":
                $document->addScript(JURI::base().'components/com_cnpsecuritysuite/assets/js/pingdom.js');
                break;
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
