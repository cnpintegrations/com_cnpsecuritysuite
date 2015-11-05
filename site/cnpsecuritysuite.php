<?php
/**
 * @version     1.0.0
 * @package     com_cnpsecuritysuite
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Tyler Oliver <tyler@cnpintegrations.com> - http://www.cnpintegrations.com
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::register('CnpsecuritysuiteFrontendHelper', JPATH_COMPONENT . '/helpers/cnpsecuritysuite.php');

// Execute the task.
$controller = JControllerLegacy::getInstance('Cnpsecuritysuite');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
