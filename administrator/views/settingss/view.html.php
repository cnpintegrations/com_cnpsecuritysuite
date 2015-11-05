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
class CnpsecuritysuiteViewSettingss extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        CnpsecuritysuiteHelper::addSubmenu('settingss');

        $this->addToolbar();

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

        JToolBarHelper::title(JText::_('COM_CNPSECURITYSUITE_TITLE_SETTINGSS'), 'settingss.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/settings';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                //JToolBarHelper::addNew('settings.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::addNew('settings.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_cnpsecuritysuite');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_cnpsecuritysuite&view=settingss');

        $this->extra_sidebar = '';
        
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
