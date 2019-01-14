<?php

namespace common\utils\helpers;

use yii\helpers\BaseStringHelper;

class StringHelper extends BaseStringHelper
{
    /**
     * Pads string on the left and right sides if it's shorter than length. Padding characters are truncated if they can't be evenly divided by length
     * @param $string
     * @param int $length
     * @param string $padStr
     *
     * @return string
     */
    public static function pad($string, $length = 0, $padStr = ' ')
    {
        return str_pad($string, $length, $padStr, STR_PAD_BOTH);
    }

    /**
     * Pads string on the right side if it's shorter than length. Padding characters are truncated if they exceed length
     * @param $string
     * @param int $length
     * @param string $padStr
     *
     * @return string
     */
    public static function padEnd($string, $length = 0, $padStr = ' ')
    {
        return str_pad($string, $length, $padStr, STR_PAD_RIGHT);
    }

    /**
     * Pads string on the left side if it's shorter than length. Padding characters are truncated if they exceed length
     * @param $string
     * @param int $length
     * @param string $padStr
     *
     * @return string
     */
    public static function padStart($string, $length = 0, $padStr = ' ')
    {
        return str_pad($string, $length, $padStr, STR_PAD_LEFT);
    }

    /**
     * Repeats the given string n times
     * @param $string
     * @param $multiplier
     *
     * @return string
     */
    public static function repeat($string, $multiplier)
    {
        return str_repeat($string, $multiplier);
    }
}