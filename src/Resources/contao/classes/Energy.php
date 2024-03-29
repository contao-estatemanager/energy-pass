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

namespace ContaoEstateManager\EnergyPass;

use Contao\FrontendTemplate;
use ContaoEstateManager\Translator;

class Energy
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'energiebar_default';

    /**
     * Add energie bar for details.
     *
     * @param $objTemplate
     * @param $arrDetails
     * @param $context
     */
    public function parseEnergiebar(&$objTemplate, &$arrDetails, $context): void
    {
        if (!\count($arrDetails) || !(bool) $context->addEnergiebar)
        {
            return;
        }

        $energyValue = $this->getEnergiepassValue($context->realEstate);
        $htmlEnergy = null;
        $index = 0;

        foreach ($arrDetails as $detail)
        {
            if ('energie' === $detail['key'] && $energyValue)
            {
                $strTemplate = $this->strTemplate;

                // set custom Template
                if ($context->energiebarTemplate)
                {
                    $strTemplate = $context->energiebarTemplate;
                }

                // create Template
                $objEnergyTemplate = new FrontendTemplate($strTemplate);

                // set template information
                $objEnergyTemplate->energieValue = $energyValue;

                if ($context->realEstate->energiepassWertklasse)
                {
                    $objEnergyTemplate->energieClass = $context->realEstate->energiepassWertklasse;
                }
                else
                {
                    $energyValue = (float) (str_replace(',', '.', $energyValue));

                    $classes = [
                        '30' => 'A+',
                        '50' => 'A',
                        '75' => 'B',
                        '100' => 'C',
                        '130' => 'D',
                        '160' => 'E',
                        '200' => 'F',
                        '225' => 'G',
                        '999' => 'H',
                    ];

                    foreach ($classes as $val => $label)
                    {
                        if ($energyValue < (int) $val)
                        {
                            $objEnergyTemplate->energieClass = $label;
                            break;
                        }
                    }
                }

                // create collection and parse Template
                $htmlEnergy = [
                    'key' => 'energiebar',
                    'label' => Translator::translateExpose('label_energiebar'),
                    'class' => 'scala',
                    'value' => $objEnergyTemplate->parse(),
                ];

                break;
            }

            ++$index;
        }

        // append parsed Template to energy details
        if (null !== $htmlEnergy)
        {
            $arrDetails[$index]['details'][] = $htmlEnergy;
        }
    }

    /**
     * Returns the correct energy value.
     *
     * @param $realEstate
     */
    public function getEnergiepassValue($realEstate): string
    {
        $strValue = '';

        if (null !== $realEstate->energiepassEpart)
        {
            switch (strtolower($realEstate->energiepassEpart))
            {
                case 'bedarf':
                    if ($realEstate->energiepassEndenergiebedarf)
                    {
                        $strValue = $realEstate->energiepassEndenergiebedarf;
                    }
                    break;

                case 'verbrauch':
                    if ($realEstate->energiepassEnergieverbrauchkennwert)
                    {
                        $strValue = $realEstate->energiepassEnergieverbrauchkennwert;
                    }
                    break;
            }
        }

        return $strValue;
    }
}
