<?php
/**
 * @package      Crowdfunding
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined("_JEXEC") or die;

$moduleclassSfx = htmlspecialchars($params->get('moduleclass_sfx'));

jimport('Prism.init');
jimport('Crowdfunding.init');
JLoader::register('CrowdfundingProfileModuleHelper', JPATH_ROOT . '/modules/mod_crowdfundingprofile/helper.php');

$option = $app->input->get('option');
$view   = $app->input->get('view');

// If option is not 'com_crowdfunding' and view is not 'details',
// do not display anything.
if ((strcmp($option, 'com_crowdfunding') !== 0) or (strcmp($view, 'details') !== 0)) {
    echo JText::_('MOD_CROWDFUNDINGPROFILE_ERROR_INVALID_VIEW');
    return;
}

$projectId = $app->input->getInt('id');
if (!$projectId) {
    echo JText::_('MOD_CROWDFUNDINGPROFILE_ERROR_INVALID_PROJECT');
    return;
}

// Get data about user.
$profile = CrowdfundingProfileModuleHelper::getData($projectId);

// Get component parameters
$componentParams = JComponentHelper::getParams('com_crowdfunding');
/** @var  $componentParams Joomla\Registry\Registry */

// Create profile object.
$socialProfiles = null;

$imageSize = $params->get('image_size', 'small');
$imageLink = $params->get('image_link', true);

$profileImage = null;
$profileLink  = null;
$profileLocation  = null;
$profileCountryCode  = null;

$container            = Prism\Container::getContainer();
$containerHelper      = new Crowdfunding\Container\Helper();

if ($profile !== null and $componentParams->get('integration_social_platform') !== null) {
    $socialProfile        = $containerHelper->fetchProfile($container, $componentParams, $profile->user_id);

    if ($socialProfile !== null) {
        $profileImage        = $socialProfile->getAvatar($imageSize);
        $profileLink         = $socialProfile->getLink();
        $profileLocation     = JText::_($socialProfile->getLocation());
        $profileCountryCode  = $socialProfile->getCountryCode();
    }
}

$proofVerified = false;
if ($profile !== null and $params->get('display_account_state', 0) and JComponentHelper::isEnabled('com_identityproof')) {
    jimport('Identityproof.init');
    $proof = $containerHelper->fetchProofProfile($container, $profile->user_id);

    if ($proof !== null and $proof->isVerified()) {
        $proofVerified  = true;
    }
}

if ($profile !== null) {
    require JModuleHelper::getLayoutPath('mod_crowdfundingprofile', $params->get('layout', 'default'));
}
