<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/energy-pass
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */


// IMMOMANAGER
$GLOBALS['TL_IMMOMANAGER_ADDONS'][] = array('Oveleon\\ContaoImmoManagerEnergyPassBundle', 'AddonManager');

if(Oveleon\ContaoImmoManagerEnergyPassBundle\AddonManager::valid()) {
    // HOOKS
    $GLOBALS['TL_HOOKS']['compileExposeDetails'][] = array('Oveleon\\ContaoImmoManagerEnergyPassBundle\\Energy', 'parseEnergiebar');
}