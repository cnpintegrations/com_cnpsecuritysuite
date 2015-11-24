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

jimport('joomla.application.component.controllerform');

/**
 * Notify controller class.
 */
class CnpsecuritysuiteControllerNotify extends JControllerForm
{

    function __construct() {
        $this->view_list = 'notifys';
        parent::__construct();
    }

}