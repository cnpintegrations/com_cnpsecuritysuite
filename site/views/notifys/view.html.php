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

		$recipients = array();
		$weekNum = $this->weekOfMonth(date("Y-m-d"));
		
		for($i = 0; i < sizeof($this->items); $i++) //Push Recipient into array based on the frequency of alerts
		{
			switch($this->items[$i]->frequency)
			{
				case 1:
					if($weekNum == 2)
					{
						array_push($recipients, $this->items[$i]->email);
					}
					break;
				case 2:
					if($weekNum == 1 || $weekNum == 3)
					{
						array_push($recipients, $this->items[$i]->email);
					}
					break;
				case 3:
				case 4:
					array_push($recipients, $this->items[$i]->email);
					break;
			}
		}
 
		$mailer->addRecipient($recipients);

		$mailer->setSubject('Your Sites Security Report');

		$watchfulReport = '<a href='.JURI::base().'administrator/index.php?option=com_cnpsecuritysuite>Security Report</a>';
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

		exec('echo "poo"');
		$this->weekNum = $weekNum;
		parent::display($tpl);
	}
	private function weekOfMonth($date) {
	    $firstOfMonth = date("Y-m-01", strtotime($date));
	    return intval(date("W", strtotime($date))) - intval(date("W", strtotime($firstOfMonth)));
	}
}
