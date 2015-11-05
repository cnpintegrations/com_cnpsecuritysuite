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
class CnpsecuritysuiteViewWatchfulis extends JViewLegacy {

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

        CnpsecuritysuiteHelper::addSubmenu('watchfulis');

        $this->addToolbar();

        $this->installed = CnpsecuritysuiteHelper::isInstalled('watchfulli');

        CnpsecuritysuiteHelper::loadScripts("watchfuli");

        $this->apikey = $this->getKey();

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

        JToolBarHelper::title(JText::_('COM_CNPSECURITYSUITE_TITLE_WATCHFULIS'), 'watchfulis.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/watchfuli';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('watchfuli.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('watchfuli.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('watchfulis.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('watchfulis.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'watchfulis.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('watchfulis.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('watchfulis.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'watchfulis.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('watchfulis.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_cnpsecuritysuite');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_cnpsecuritysuite&view=watchfulis');

        $this->extra_sidebar = '';
        //
    }

    protected function getKey ()
    {
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);
 
        // Create the base select statement.
        $query->select('*')
                ->from($db->quoteName('#__cnpsecuritysuite_keys'))
                ->where($db->quoteName('id') . ' = '. $db->quote(1));
        $db->setQuery($query);
 
        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        return $results[0]->apikey;
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
