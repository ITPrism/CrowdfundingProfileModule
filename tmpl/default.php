<?php
/**
 * @package      Crowdfunding
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2017 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<div class="cf-modprofile<?php echo $moduleclassSfx; ?>">
    <div><?php echo JText::_('MOD_CROWDFUNDINGPROFILE_PROJECT_BY') .' '. JHtml::_('crowdfunding.profileName', $profile->name, $profileLink, $proofVerified); ?></div>
    <div class="media">
        <?php if ($profileImage !== null) { ?>
            <?php if ($params->get('image_link', 0)) { ?>
            <a href="<?php echo $profileLink; ?>" class="media-left" >
            <?php } ?>
            <img class="media-object" src="<?php echo $profileImage; ?>" alt="<?php echo htmlspecialchars($profile->name, ENT_QUOTES, 'UTF-8'); ?>" width="<?php echo $imageSize; ?>" height="<?php echo $imageSize; ?>"/>
            <?php if ($params->get('image_link', 0)) { ?>
            </a>
            <?php } ?>
        <?php } ?>
        <div class="media-body">
            <?php
            if ($params->get('display_location', 0)) {
                echo JHtml::_('crowdfunding.profileLocation', $profileLocation, $profileCountryCode);
            }?>
        </div>
    </div>
</div>