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

use Contao\Config;
use Contao\Environment;
use ContaoEstateManager\EstateManager;

class AddonManager
{
    /**
     * Bundle name
     * @var string
     */
    public static $bundle = 'EstateManagerEnergyPass';

    /**
     * Package
     * @var string
     */
    public static $package = 'contao-estatemanager/energy-pass';

    /**
     * Addon config key
     * @var string
     */
    public static $key  = 'addon_energy_license';

    /**
     * Is initialized
     * @var boolean
     */
    public static $initialized  = false;

    /**
     * Is valid
     * @var boolean
     */
    public static $valid  = false;

    /**
     * Licenses
     * @var array
     */
    private static $licenses = [
        'c0da573c2d6081c803c83be4f59258e0',
        'b1c37910eed504e5480fce220ba9c020',
        '5958340e12766ad5a8ba866425ab5ad3',
        '757500ee8a24824201f4a7ef1a17b7ff',
        'e35b4957f54acf1798e7c02e4b444cc9',
        '3f8cbc2dc01aa9fc4feb57bf6a3fbe90',
        'ecf08137670d4c3057586e6901a4ae5f',
        'ff5b89574abc6534e6f946db0f9ebb61',
        'c828bc8066a6a48b317f16b16f8a4bbd',
        'e1591a3d302cca35812dee90ed2699b5',
        '9e17cb80b222149acc34bbadef42a02f',
        '9d8a4c6172115c5ca8d65fcdaafb1d5a',
        '2fbf6214f83953c6cd0af28bc91eabdd',
        '7f20e27263c959b47dfb55470c35f2d9',
        'fe9fb1f0598ce2fc82298fc8b8fa3316',
        '51453e54e068eb1a7b3bba5beb3ec445',
        'aeae484aed1898aad2e0cddf15684399',
        'abe478326a5e62f28648da745f3f96cb',
        'c84240e85ab929f95fe5c5f14084ea75',
        'c614143601757f4922b49386c9f42e42',
        '5b4dcfccda90837e58eddefdacea14b4',
        'fa0dab7b83ba686465032fb2c7e54b83',
        'def308c410e0eb034256ff7efd79f618',
        'fbaa067aa9b2bb44493467129a3a6893',
        'e9cdd93613bc36f8b4c4626597643c7c',
        '6eb7b69577b52c2c47b1754d32db6e16',
        '6e1e7305621e1a3108fb374a1b5e3307',
        '3f17aa755ed5ac028de4ae298d1e9a1c',
        'a55053f0210790d5738ec4e6e7728e6b',
        'c2452913ab996d5692a1ea84f7f6efa0',
        'd39980afd531e005932e4583ccb0c7e4',
        'f067ab531514305a8ca7aeda753c3f57',
        '5a04b64f7e972517adbf03d6b093633e',
        'd39980afd531e005932e4583ccb0c7e4',
        '7be17bd53c1d63705f9bcb6668b82091',
        '7d2eaf0695493a3c96bed932dd27af80',
        'cb29127ed8d07caa5b7a8119be9c589d',
        '8c0beda9cc2162d85c5d38baf17fb810',
        '376d1015f67bfa8a325bbfdf970dbac6',
        'b026a527c82eb54f657f2ac77f1731b4',
        '9cf20fbdc50cd48b08e8abd2a2846c9f',
        'bf04a421dcb2196c15cb57bb0deaf741',
        '0ef9625442353ea0631b200ecfbe03c1',
        '59c4a333a3a574441cb96f75b56baa41',
        '59b4cb0c8d3dd422dd56ec0aa2e6048b',
        '74fa137bf3340357a998260241456add',
        'b27a2d1548b9df07570c83d35f17ac57',
        '0426e0c632c157ec6f32944890832bea',
        '5df61b79ba6293cb1a81b91787fa8730',
        '247b117a96c92991f37788f1ba61f7cae'
    ];

    public static function getLicenses()
    {
        return static::$licenses;
    }

    public static function valid()
    {
        if(strpos(Environment::get('requestUri'), '/contao/install') !== false)
        {
            return true;
        }

        if (static::$initialized === false)
        {
            static::$valid = EstateManager::checkLicenses(Config::get(static::$key), static::$licenses, static::$key);
            static::$initialized = true;
        }

        return static::$valid;
    }

}
