<?php
/**
 * @package      Crowdfunding
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class CrowdfundingProfileModuleHelper
{
    public static function getData($projectId)
    {
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);
        
        $query
            ->select('a.user_id, b.name')
            ->from($db->quoteName('#__crowdf_projects', 'a'))
            ->innerJoin($db->quoteName('#__users', 'b') . ' ON a.user_id = b.id')
            ->where('a.id ='.(int)$projectId);
        
        $db->setQuery($query, 0, 1);
        return $db->loadObject();
    }
}
