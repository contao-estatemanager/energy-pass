<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/energy-pass
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

if(ContaoEstateManager\EnergyPass\AddonManager::valid()) {
    // Add fields
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['addEnergiebar'] = array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_expose_module']['addEnergiebar'],
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'w50 m12'),
        'sql'                       => "char(1) NOT NULL default '0'",
    );

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['energiebarTemplate'] = array(
        'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['energiebarTemplate'],
        'default'                 => 'energiebar_default',
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => function (){
            return Contao\Controller::getTemplateGroup('energiebar_');
        },
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    );

    // Extend the details palettes
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addLegend('energy_legend', 'template_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
        ->addField(array('addEnergiebar'), 'energy_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->addField(array('energiebarTemplate'), 'template_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('details', 'tl_expose_module')
    ;
}
