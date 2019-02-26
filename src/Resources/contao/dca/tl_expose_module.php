<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

// Add field
array_insert($GLOBALS['TL_DCA']['tl_expose_module']['fields'], -1, array(
    'addEnergiebar'  => array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_expose_module']['addEnergiebar'],
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'w50 m12'),
        'sql'                       => "char(1) NOT NULL default '0'",
    ),
    'energiebarTemplate' => array(
        'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['energiebarTemplate'],
        'default'                 => 'energiebar_default',
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => array('tl_module_immo_manager_energy', 'getEnergiebarTemplates'),
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    )
));

// Extend the details palettes
Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('energy_legend', 'template_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
    ->addField(array('addEnergiebar'), 'energy_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->addField(array('energiebarTemplate'), 'template_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('details', 'tl_expose_module')
;

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class tl_module_immo_manager_energy extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Return all energy bar templates as array
     *
     * @return array
     */
    public function getEnergiebarTemplates()
    {
        return $this->getTemplateGroup('energiebar_');
    }
}