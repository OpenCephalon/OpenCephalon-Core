<?php

namespace OpenCephalonBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class OpenCephalonBundle extends Bundle
{


    static function createKey($minLength = 10, $maxLength = 100)
    {
        // This is set to make readable Ids.
        $characters = '23456789abcdefghjkmnpqrstuvwxyz';
        $string ='';
        $length = mt_rand($minLength, $maxLength);
        for ($p = 0; $p < $length; $p++)
        {
            $string .= $characters[mt_rand(0, strlen($characters)-1)];
        }
        return $string;
    }

}
