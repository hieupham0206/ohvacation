<?php
/**
 * Created by PhpStorm.
 * User: Team
 * Date: 8/17/2016
 * Time: 12:11 PM
 */

namespace common\utils\helpers;

use Yii;
use yii\i18n\PhpMessageSource;

class Inflector extends \yii\helpers\Inflector
{
    /**
     * Initialize translations
     * @throws \yii\base\InvalidParamException
     */
    public static function initI18N()
    {
        if ( ! empty(Yii::$app->i18n->translations['yii'])) {
            return;
        }
        Yii::setAlias('@yii', __DIR__);
        Yii::$app->i18n->translations['yii*'] = [
            'class'            => PhpMessageSource::class,
            'basePath'         => '@yii/messages',
            'forceTranslation' => true
        ];
    }

    /**
     * Check if a variable is empty or not set.
     *
     * @param mixed $var variable to perform the check
     *
     * @return boolean
     */
    public static function isEmpty($var)
    {
        /** @noinspection UnSafeIsSetOverArrayInspection */
        /** @noinspection NestedTernaryOperatorInspection */
        return ! isset($var) ? true : (is_array($var) ? empty($var) : ($var === null || $var === ''));
    }

    /**
     * Check if a value exists in the array. This method is faster in performance than the built in PHP in_array method.
     *
     * @param string $needle the value to search
     * @param array $haystack the array to scan
     *
     * @return boolean
     */
    public static function inArray($needle, $haystack)
    {
        $flippedHaystack = array_flip($haystack);

        return isset($flippedHaystack[$needle]);
    }

    /**
     * Properize a string for possessive punctuation.
     *
     * @param string $string input string
     *
     * Example:
     * ~~~
     * properize("Chris"); //returns Chris'
     * properize("David"); //returns David's
     * ~~~
     *
     * @return string
     */
    public static function properize($string)
    {
        $string = preg_replace('/\s+(.*?)\s+/', '*\1*', $string);

        return $string . '\'' . ($string[strlen($string) - 1] != 's' ? 's' : '');
    }

    /**
     * Format and convert "bytes" to its optimal higher metric unit
     *
     * @param double $bytes number of bytes
     * @param integer $precision the number of decimal places to round off
     *
     * @return string
     */
    public static function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow   = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow   = min($pow, count($units) - 1);

        $bytes /= $pow ** 1024;

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Number to words conversion. Returns the number converted as an anglicized string.
     *
     * @param int $num the source number
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public static function numToWords($num)
    {
        $num = (int)$num; // make sure it's an integer
        if ($num < 0) {
            return Yii::t('yii', 'minus') . ' ' . static::convertTri(-$num, 0);
        }
        if ($num == 0) {
            return Yii::t('yii', 'zero');
        }

        return static::convertTri($num, 0);
    }

    /**
     * Recursive function used in number to words conversion. Converts three digits per pass.
     *
     * @param double $num the source number
     * @param int $tri the three digits converted per pass.
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    protected static function convertTri($num, $tri)
    {
        // chunk the number ...xyz
        $x = (int)($num / 1000);
        $y = ($num / 100) % 10;
        $z = $num % 100;

        // init the output string
        $str      = '';
        $ones     = static::generateOnes();
        $tens     = static::generateTens();
        $triplets = static::generateTriplets();

        // do hundreds
        if ($y > 0) {
            $str = $ones[$y] . ' ' . Yii::t('yii', 'hundred');
        }

        // do ones and tens
        $str .= $z < 20 ? $ones[$z] : $tens[(int)($z / 10)] . $ones[$z % 10];

        // add triplet modifier only if there is some output to be modified...
        if ($str != '') {
            $str .= $triplets[$tri];
        }

        // recursively process until valid thousands digit found
        return $x > 0 ? static::convertTri($x, $tri + 1) . $str : $str;
    }

    /**
     * Generate list of ones
     *
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    public static function generateOnes()
    {
        static::initI18N();

        return [
            '',
            ' ' . Yii::t('yii', 'one'),
            ' ' . Yii::t('yii', 'two'),
            ' ' . Yii::t('yii', 'three'),
            ' ' . Yii::t('yii', 'four'),
            ' ' . Yii::t('yii', 'five'),
            ' ' . Yii::t('yii', 'six'),
            ' ' . Yii::t('yii', 'seven'),
            ' ' . Yii::t('yii', 'eight'),
            ' ' . Yii::t('yii', 'nine'),
            ' ' . Yii::t('yii', 'ten'),
            ' ' . Yii::t('yii', 'eleven'),
            ' ' . Yii::t('yii', 'twelve'),
            ' ' . Yii::t('yii', 'thirteen'),
            ' ' . Yii::t('yii', 'fourteen'),
            ' ' . Yii::t('yii', 'fifteen'),
            ' ' . Yii::t('yii', 'sixteen'),
            ' ' . Yii::t('yii', 'seventeen'),
            ' ' . Yii::t('yii', 'eighteen'),
            ' ' . Yii::t('yii', 'nineteen')
        ];
    }

    /**
     * Generate list of tens
     *
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    public static function generateTens()
    {
        static::initI18N();

        return [
            '',
            '',
            ' ' . Yii::t('yii', 'twenty'),
            ' ' . Yii::t('yii', 'thirty'),
            ' ' . Yii::t('yii', 'forty'),
            ' ' . Yii::t('yii', 'fifty'),
            ' ' . Yii::t('yii', 'sixty'),
            ' ' . Yii::t('yii', 'seventy'),
            ' ' . Yii::t('yii', 'eighty'),
            ' ' . Yii::t('yii', 'ninety')
        ];
    }

    /**
     * Generate list of triplets
     *
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    public static function generateTriplets()
    {
        static::initI18N();

        return [
            '',
            ' ' . Yii::t('yii', 'thousand'),
            ' ' . Yii::t('yii', 'million'),
            ' ' . Yii::t('yii', 'billion'),
            ' ' . Yii::t('yii', 'trillion'),
            ' ' . Yii::t('yii', 'quadrillion'),
            ' ' . Yii::t('yii', 'quintillion'),
            ' ' . Yii::t('yii', 'sextillion'),
            ' ' . Yii::t('yii', 'septillion'),
            ' ' . Yii::t('yii', 'octillion'),
            ' ' . Yii::t('yii', 'nonillion'),
        ];
    }

    /**
     * Generates a boolean list
     *
     * @param string $false the label for the false value
     * @param string $true the label for the true value
     *
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    public static function generateBoolList($false = null, $true = null)
    {
        static::initI18N();

        return [
            false => empty($false) ? Yii::t('yii', 'No') : $false, // == 0
            true  => empty($true) ? Yii::t('yii', 'Yes') : $true,  // == 1
        ];
    }

    /**
     * Parses and returns a variable type
     *
     * @param string $var the variable to be parsed
     *
     * @return string
     */
    public static function getType($var)
    {
        if (is_array($var)) {
            return 'array';
        } elseif (is_object($var)) {
            return 'object';
        } elseif (is_resource($var)) {
            return 'resource';
        } /** @noinspection IsNullFunctionUsageInspection */ elseif (is_null($var)) {
            return 'NULL';
        } elseif (is_bool($var)) {
            return 'boolean';
        } elseif (is_float($var) || (is_numeric(str_replace(',', '', $var)) && strpos($var, '.') > 0 &&
                                     is_float((float)str_replace(',', '', $var)))
        ) {
            return 'float';
        } /** @noinspection CallableParameterUseCaseInTypeContextInspection */ elseif (is_int($var) || (is_numeric($var) && is_int((int)$var))) {
            return 'integer';
        } elseif (is_scalar($var) && strtotime($var) !== false) {
            return 'datetime';
        } /** @noinspection NotOptimalIfConditionsInspection */ elseif (is_scalar($var)) {
            return 'string';
        }

        return 'unknown';
    }
}