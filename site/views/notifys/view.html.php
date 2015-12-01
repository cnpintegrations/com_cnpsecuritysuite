<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Cnpsecuritysuite
 * @author     Tyler Oliver <tyler@cnpintegrations.com>
 * @copyright  Copyright (C) 2015. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Cnpsecuritysuite.
 *
 * @since  1.6
 */
class CnpsecuritysuiteViewNotifys extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	protected $params;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$app = JFactory::getApplication();

		$this->state      = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->params     = $app->getParams('com_cnpsecuritysuite');
		

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		$mailer = JFactory::getMailer();

		$config = JFactory::getConfig();
		$sender = array( 
		    $config->get( 'mailfrom' ),
		    $config->get( 'fromname' ) 
		);
		 
		$mailer->setSender($sender);

		$recipient = array("tyler8oliver@gmail.com");
 
		$mailer->addRecipient($recipient);

		$mailer->setSubject('Your Sites Security Report');

		$watchfulReport = '<a href='.JURI::base( true ).'administrator/index.php?option=com_cnpsecuritysuite>Security Report</a>';
		$body   = '<h2>Reminder!</h2>'
	    . '<div>Your Joomla site has a new report pertaining to its security status.'
	    .' Be sure to view it at '.$watchfulReport
	    .'</div>';
		
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';

		$mailer->setBody($body);

		$send = $mailer->Send();
		if ( $send !== true ) {
		    echo 'Error sending email: ' . $send->__toString();
		} else {
		    echo 'Mail sent';
		}

		parent::display($tpl);
	}
}
