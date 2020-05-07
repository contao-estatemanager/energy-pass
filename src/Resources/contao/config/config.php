<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/energy-pass
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = array('ContaoEstateManager\\EnergyPass', 'AddonManager');

if(ContaoEstateManager\EnergyPass\AddonManager::valid()) {
    // Hooks
    $GLOBALS['TL_HOOKS']['compileExposeDetails'][] = array('ContaoEstateManager\\EnergyPass\\Energy', 'parseEnergiebar');
}
