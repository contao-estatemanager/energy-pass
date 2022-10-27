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

use Contao\Controller;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use ContaoEstateManager\EnergyPass\AddonManager;

if (AddonManager::valid())
{
    // Add fields
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['addEnergiebar'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['addEnergiebar'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50'],
        'sql' => "char(1) NOT NULL default '0'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['energiebarTemplate'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['energiebarTemplate'],
        'default' => 'energiebar_default',
        'exclude' => true,
        'inputType' => 'select',
        'options_callback' => static fn () => Controller::getTemplateGroup('energiebar_'),
        'eval' => ['tl_class' => 'w50'],
        'sql' => "varchar(64) NOT NULL default ''",
    ];

    // Extend the details palettes
    PaletteManipulator::create()
        ->addLegend('energy_legend', 'template_legend', PaletteManipulator::POSITION_BEFORE)
        ->addField(['addEnergiebar'], 'energy_legend', PaletteManipulator::POSITION_APPEND)
        ->addField(['energiebarTemplate'], 'template_legend', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('details', 'tl_expose_module')
    ;
}
