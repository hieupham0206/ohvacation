<?php
/**
 * Created by PhpStorm.
 * User: Team
 * Date: 11/15/2016
 * Time: 4:30 PM
 */

namespace common\utils\helpers;

use Yii;
use yii\i18n\PhpMessageSource;

class ClientHelper
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
     * Gets the user's IP address
     *
     * @param boolean $filterLocal whether to filter local & LAN IP (defaults to true)
     *
     * @return string
     */
    public static function getUserIP($filterLocal = true)
    {
        $ipSources = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];
        foreach ($ipSources as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                    if ($filterLocal) {
                        $checkFilter = filter_var(
                            $ip,
                            FILTER_VALIDATE_IP,
                            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
                        );
                        if ($checkFilter !== false) {
                            return $ip;
                        }
                    } else {
                        return $ip;
                    }
                }
            }
        }

        return 'Unknown';
    }

    /**
     * Gets basic browser information
     *
     * @param boolean $common show common browsers only
     * @param array $browsers the list of browsers
     * @param string $agent user agent
     *
     * @return array the browser information
     * @throws \yii\base\InvalidParamException
     */
    public static function getBrowser($common = false, array $browsers = array(), $agent = null)
    {
        static::initI18N();
        if ($agent === null) {
            $agent = $_SERVER['HTTP_USER_AGENT'];
        }
        if ($common) {
            $browsers = [
                'opera'         => Yii::t('yii', 'Opera'),
                'chrome'        => Yii::t('yii', 'Google Chrome'),
                'safari'        => Yii::t('yii', 'Safari'),
                'firefox'       => Yii::t('yii', 'Mozilla Firefox'),
                'msie'          => Yii::t('yii', 'Microsoft Internet Explorer'),
                'mobile safari' => Yii::t('yii', 'Mobile Safari'),
            ];
        } elseif (empty($browsers)) {
            $browsers = [
                'opera'         => Yii::t('yii', 'Opera'),
                'maxthon'       => Yii::t('yii', 'Maxthon'),
                'seamonkey'     => Yii::t('yii', 'Mozilla Sea Monkey'),
                'arora'         => Yii::t('yii', 'Arora'),
                'avant'         => Yii::t('yii', 'Avant'),
                'omniweb'       => Yii::t('yii', 'Omniweb'),
                'epiphany'      => Yii::t('yii', 'Epiphany'),
                'chromium'      => Yii::t('yii', 'Chromium'),
                'galeon'        => Yii::t('yii', 'Galeon'),
                'puffin'        => Yii::t('yii', 'Puffin'),
                'fennec'        => Yii::t('yii', 'Mozilla Firefox Fennec'),
                'chrome'        => Yii::t('yii', 'Google Chrome'),
                'mobile safari' => Yii::t('yii', 'Mobile Safari'),
                'safari'        => Yii::t('yii', 'Apple Safari'),
                'firefox'       => Yii::t('yii', 'Mozilla Firefox'),
                'iemobile'      => Yii::t('yii', 'Microsoft Internet Explorer Mobile'),
                'msie'          => Yii::t('yii', 'Microsoft Internet Explorer'),
                'konqueror'     => Yii::t('yii', 'Konqueror'),
                'amaya'         => Yii::t('yii', 'Amaya'),
                'netscape'      => Yii::t('yii', 'Netscape'),
                'mosaic'        => Yii::t('yii', 'Mosaic'),
                'netsurf'       => Yii::t('yii', 'NetSurf'),
                'netfront'      => Yii::t('yii', 'NetFront'),
                'minimo'        => Yii::t('yii', 'Minimo'),
                'blackberry'    => Yii::t('yii', 'Blackberry'),
            ];
        }
        $info = [
            'agent'    => $agent,
            'code'     => 'other',
            'name'     => 'Other',
            'version'  => '?',
            'platform' => 'Unknown'
        ];

        if (preg_match('/iphone|ipod|ipad/i', $agent)) {
            $info['platform'] = 'ios';
        } elseif (preg_match('/android/i', $agent)) {
            $info['platform'] = 'android';
        } elseif (preg_match('/symbian/i', $agent)) {
            $info['platform'] = 'symbian';
        } elseif (preg_match('/maemo/i', $agent)) {
            $info['platform'] = 'maemo';
        } elseif (preg_match('/palm/i', $agent)) {
            $info['platform'] = 'palm';
        } elseif (preg_match('/linux/i', $agent)) {
            $info['platform'] = 'linux';
        } elseif (preg_match('/mac/i', $agent)) {
            $info['platform'] = 'mac';
        } elseif (preg_match('/win/i', $agent)) {
            $info['platform'] = 'windows';
        } elseif (preg_match('/x11|bsd|sun/i', $agent)) {
            $info['platform'] = 'unix';
        }

        foreach ($browsers as $code => $name) {
            if (preg_match("/{$code}/i", $agent)) {
                $info['code']    = $code;
                $info['name']    = $name;
                $info['version'] = static::getBrowserVer($agent, $code);

                return $info;
            }
        }

        return $info;
    }

    /**
     * Returns browser version
     *
     * @param string $agent the user agent string
     * @param string $code the browser string
     *
     * @return float
     */
    protected static function getBrowserVer($agent, $code)
    {
        $version = '?';
        $pattern = '#(?<browser>' . $code . ')[/v ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';
        if ($code == 'blackberry') {
            $pattern = '#(?<browser>' . $code . ')[/v0-9 ]+(?<version>[0-9]+(?:\.[0-9]+)?)#';
        }
        if (preg_match_all($pattern, strtolower($agent), $matches)) {
            $i       = count($matches['browser']) - 1;
            $ver     = [$matches['browser'][$i] => $matches['version'][$i]];
            $version = empty($ver[$code]) ? '?' : $ver[$code];
        }

        return $version;
    }
}