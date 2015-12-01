<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Script file of HelloWorld component
 */
class Com_cnpsecuritysuiteInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		// set cron tabs
		$requestUrl = JURI::base( true ).'?option=com_cnpsecuritysuite&view=notifys';

		str_ireplace('administrator/', '', $requestUrl);

		echo $requestUrl;

		exec('crontab -l', $output);

		file_put_contents('/tmp/crontab.txt', $output.' * * * * * curl -s '.$requestUrl);

		exec('crontab /tmp/crontab.txt');

		$parent->getParent()->setRedirectURL('index.php?option=com_cnpsecuritysuite');
	}
 
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		//Delete cron tabs
		exec('crontab -r');
	}
 
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
		
	}
 
	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{

	}
 
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
	
	}
}