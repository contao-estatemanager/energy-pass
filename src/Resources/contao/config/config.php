<?php

declare(strict_types=1);

/*
 * This file is part of Contao EstateManager.
 *
 * @see        https://www.contao-estatemanager.com/
 * @source     https://github.com/contao-estatemanager/energy-pass
 * @copyright  Copyright (c) 2021 Oveleon GbR (https://www.oveleon.de)
 * @license    https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = ['ContaoEstateManager\EnergyPass', 'AddonManager'];

use ContaoEstateManager\EnergyPass\AddonManager;
use ContaoEstateManager\EnergyPass\Energy;

if (AddonManager::valid())
{
    // Hooks
    $GLOBALS['CEM_HOOKS']['compileExposeDetails'][] = [Energy::class, 'parseEnergiebar'];
}
