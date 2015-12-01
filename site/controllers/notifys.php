<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Cnpsecuritysuite
 * @author     Tyler Oliver <tyler@cnpintegrations.com>
 * @copyright  Copyright (C) 2015. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Notifys list controller class.
 *
 * @since  1.6
 */
class CnpsecuritysuiteControllerNotifys extends CnpsecuritysuiteController
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional
	 * @param   array   $config  Configuration array for model. Optional
	 *
	 * @return object	The model
	 *
	 * @since	1.6
	 */
	public function &getModel($name = 'Notifys', $prefix = 'CnpsecuritysuiteModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
}
