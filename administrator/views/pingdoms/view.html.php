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

jimport('joomla.application.component.view');

/**
 * View class for a list of Cnpsecuritysuite.
 */
class CnpsecuritysuiteViewPingdoms extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        CnpsecuritysuiteHelper::addSubmenu('pingdoms');

        $this->addToolbar();

        $vendor = Cnpsecuritysuite::getVendor(2);

        $this->apikey = (isset($vendor)) ? $vendor->apikey : null;

        $this->installed = CnpsecuritysuiteHelper::isInstalled('pingdom');

        CnpsecuritysuiteHelper::loadScripts("pingdom");

        $this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/cnpsecuritysuite.php';

        $state = $this->get('State');
        $canDo = CnpsecuritysuiteHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_CNPSECURITYSUITE_TITLE_PINGDOMS'), 'pingdoms.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/pingdom';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('pingdom.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('pingdom.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('pingdoms.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('pingdoms.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'pingdoms.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('pingdoms.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('pingdoms.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'pingdoms.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('pingdoms.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_cnpsecuritysuite');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_cnpsecuritysuite&view=pingdoms');

        $this->extra_sidebar = '';
        //
    }

	protected function getSortFields()
	{
		return array(
		'a.`id`' => JText::_('JGRID_HEADING_ID'),
		'a.`apikey`' => JText::_('COM_CNPSECURITYSUITE_SETTINGSS_APIKEY'),
		'a.`vendor`' => JText::_('COM_CNPSECURITYSUITE_SETTINGSS_VENDOR'),
		);
	}

}
