<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Cnpsecuritysuite
 * @author     Tyler Oliver <tyler@cnpintegrations.com>
 * @copyright  Copyright (C) 2015. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::register('CnpsecuritysuiteFrontendHelper', JPATH_COMPONENT . '/helpers/cnpsecuritysuite.php');

// Execute the task.
$controller = JControllerLegacy::getInstance('Cnpsecuritysuite');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
