<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/energy-pass
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

namespace ContaoEstateManager\EnergyPass;

use ContaoEstateManager\Translator;

class Energy
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'energiebar_default';

    /**
     * Add energie bar for details
     *
     * @param $objTemplate
     * @param $arrDetails
     * @param $context
     */
    public function parseEnergiebar(&$objTemplate, &$arrDetails, $context)
    {
        if(!count($arrDetails) || !!!$context->addEnergiebar)
        {
            return;
        }

        $htmlEnergy = null;
        $index = 0;

        foreach ($arrDetails as $detail)
        {
            if($detail['key'] === 'energie')
            {
                $strTemplate = $this->strTemplate;
                $energyValue = $this->getEnergiepassValue($context->realEstate);

                // set custom Template
                if($context->energiebarTemplate)
                {
                    $strTemplate = $context->energiebarTemplate;
                }

                // create Template
                $objEnergyTemplate = new \FrontendTemplate($strTemplate);

                // set template information
                $objEnergyTemplate->energieValue = $energyValue;

                if($context->realEstate->energiepassWertklasse)
                {
                    $objEnergyTemplate->energieClass = $context->realEstate->energiepassWertklasse;
                }
                else
                {
                    $energyValue = floatval(str_replace( ',', '.', $energyValue));

                    $classes = array(
                        '30' => 'A+',
                        '50' => 'A',
                        '75' => 'B',
                        '100' => 'C',
                        '130' => 'D',
                        '160' => 'E',
                        '200' => 'F',
                        '225' => 'G',
                        '999' => 'H'
                    );

                    foreach ($classes as $val => $label)
                    {
                        if($energyValue < intval($val))
                        {
                            $objEnergyTemplate->energieClass = $label;
                            break;
                        }
                    }
                }

                // create collection and parse Template
                $htmlEnergy = array(
                    'key'   => 'energiebar',
                    'label' => Translator::translateExpose('label_energiebar'),
                    'class' => 'scala',
                    'value' => $objEnergyTemplate->parse()
                );

                break;
            }

            $index++;
        }

        // append parsed Template to energy details
        if($htmlEnergy)
        {
            $arrDetails[ $index ]['details'][] = $htmlEnergy;
        }
    }

    /**
     * Returns the correct energy value
     *
     * @param $realEstate
     *
     * @return string
     */
    public function getEnergiepassValue($realEstate)
    {
        switch(strtolower($realEstate->objRealEstate->energiepassEpart))
        {
            case 'bedarf':
                return $realEstate->objRealEstate->energiepassEndenergiebedarf;
                break;
            case 'verbrauch':
                return $realEstate->objRealEstate->energiepassEnergieverbrauchkennwert;
                break;
        }

        return '';
    }
}