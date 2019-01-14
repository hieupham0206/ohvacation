<?php
namespace common\utils\helpers;

use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;

class Security extends \yii\base\Security
{
    const RANDOM_INT_LOOP_LIMIT = 123;

    /**
     * Generates a random UUID using the secure RNG.
     *
     * Returns Version 4 UUID format: xxxxxxxx-xxxx-4xxx-Yxxx-xxxxxxxxxxxx where x is
     * any random hex digit and Y is a random choice from 8, 9, a, or b.
     * @return string the UUID
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\Exception
     */
    public function generateUuidV4()
    {
        $bytes    = Yii::$app->security->generateRandomKey(16);
        $bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x40);
        $bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);
        $chunks   = str_split(bin2hex($bytes), 4);

        return "{$chunks[0]}{$chunks[1]}-{$chunks[2]}-{$chunks[3]}-{$chunks[4]}-{$chunks[5]}{$chunks[6]}{$chunks[7]}";
    }

    /**
     * Returns a random integer in the range $min..$max inclusive.
     *
     * Substitutes for the random_int() in PHP 7.
     *
     * @param int $min Minimum value of the returned integer. Default = 0.
     * @param int $max Maximum value of the returned integer Default = 9999.
     *
     * @return int The generated random integer.
     * @throws \yii\base\InvalidParamException
     * @throws \yii\base\Exception
     */
    public function generateRandomInt($min = 0, $max = 9999)
    {
        if (function_exists('random_int')) {
            return random_int($min, $max);
        }
        if ( ! is_int($min)) {
            throw new InvalidParamException('First parameter ($min) must be an integer');
        }
        if ( ! is_int($max)) {
            throw new InvalidParamException('Second parameter ($max) must be an integer');
        }
        if ($min > $max) {
            throw new InvalidParamException('First parameter ($min) must be no greater than second parameter ($max)');
        }
        if ($min === $max) {
            return $min;
        }
        // $range is a PHP float if the expression exceeds PHP_INT_MAX.
        $range = $max - $min + 1;
        if (is_float($range)) {
            $mask = null;
        } else {
            // Make a bit mask of (the next highest power of 2 >= $range) minus one.
            $mask  = 1;
            $shift = $range;
            while ($shift > 1) {
                $shift >>= 1;
                $mask = ($mask << 1) | 1;
            }
        }
        $tries = 0;
        do {
            $bytes = Yii::$app->security->generateRandomKey(PHP_INT_SIZE);
            // Convert byte string to a signed int by shifting each byte in.
            $value = 0;
            /** @noinspection ForeachInvariantsInspection */
            for ($pos = 0; $pos < PHP_INT_SIZE; $pos++) {
                $value = ($value << 8) | ord($bytes[$pos]);
            }
            if ($mask === null) {
                // Use all bits in $bytes and check $value against $min and $max instead of $range.
                if ($value >= $min && $value <= $max) {
                    return $value;
                }
            } else {
                // Use only enough bits from $bytes to cover the $range.
                $value &= $mask;
                if ($value < $range) {
                    return $value + $min;
                }
            }
            $tries++;
        } while ($tries < self::RANDOM_INT_LOOP_LIMIT);
        // Worst case: this is as likely as self::RANDOM_INT_LOOP_LIMIT heads in as many coin tosses.
        throw new Exception('Unable to generate random int after ' . self::RANDOM_INT_LOOP_LIMIT . ' tries');
    }

    /**
     * Generates user-friendly random password containing at least one lower case letter, one uppercase letter, one special character and one
     * digit. The remaining characters in the password are chosen at random from those three sets.
     *
     * @see https://gist.github.com/tylerhall/521810
     *
     * @param $length
     *
     * @return string
     */
    public function generateRandomPassword($length = 8)
    {
        $sets     = [
            'abcdefghjkmnpqrstuvwxyz',
            'ABCDEFGHJKMNPQRSTUVWXYZ',
            '0123456789',
            '!@#$%&*?_-~()=+^'
        ];
        $all      = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $password .= $all[array_rand($all)];
        }

        $password = str_shuffle($password);

        return $password;
    }

    /**
     * @param int $type
     * type == 0: otp la số, độ dài = 6
     * type == 1: otp là chuỗi bất kì, độ dài = 6
     *
     * @return int|string
     * @throws \yii\base\InvalidParamException
     * @throws Exception
     */
    public function generateOtp($type = 0)
    {
        if ($type == 1) {
            return $this->generateRandomString(6);
        }

        return $this->generateRandomInt(100000, 999999);
    }

    /**
     * simple method to encrypt or decrypt a plain text string
     * initialization vector(IV) has to be the same when encrypting and decrypting
     * PHP 5.4.9 ( check your PHP version for function definition changes )
     *
     * @param string $action : can be 'encrypt' or 'decrypt'
     * @param string $string : string to encrypt or decrypt
     *
     * @return string
     */
    public function encrypt_decrypt($action, $string)
    {
        $output = false;

        $encryptMethod = 'AES-256-CBC';
        $secretKey     = Yii::$app->security->authKeyInfo;
        $secretIv      = Yii::$app->security->authKeyInfo;

        // hash
        $key = hash('sha256', $secretKey);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secretIv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encryptMethod, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encryptMethod, $key, 0, $iv);
        }

        return $output;
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     */
    protected function encrypt($data, $passwordBased, $secret, $info)
    {
        if ( ! extension_loaded('openssl')) {
            throw new InvalidConfigException('Encryption requires the OpenSSL PHP extension');
        }
        if ( ! isset($this->allowedCiphers[$this->cipher][0], $this->allowedCiphers[$this->cipher][1])) {
            throw new InvalidConfigException($this->cipher . ' is not an allowed cipher');
        }

        list($blockSize, $keySize) = $this->allowedCiphers[$this->cipher];

        $keySalt = $this->generateRandomString($keySize);
        if ($passwordBased) {
            $key = $this->pbkdf2($this->kdfHash, $secret, $keySalt, $this->derivationIterations, $keySize);
        } else {
            $key = $this->hkdf($this->kdfHash, $secret, $keySalt, $info, $keySize);
        }

        $iv = $this->generateRandomString($blockSize);

        $encrypted = openssl_encrypt($data, $this->cipher, $key, OPENSSL_KEYTYPE_RSA, $iv);
        if ($encrypted === false) {
            throw new Exception('OpenSSL failure on encryption: ' . openssl_error_string());
        }

        $authKey = $this->hkdf($this->kdfHash, $key, null, $this->authKeyInfo, $keySize);
        $hashed  = $this->hashData($iv . $encrypted, $authKey);

        /*
         * Output: [keySalt][MAC][IV][ciphertext]
         * - keySalt is KEY_SIZE bytes long
         * - MAC: message authentication code, length same as the output of MAC_HASH
         * - IV: initialization vector, length $blockSize
         */

        return $keySalt . $hashed;
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     */
    protected function decrypt($data, $passwordBased, $secret, $info)
    {
        if ( ! extension_loaded('openssl')) {
            throw new InvalidConfigException('Encryption requires the OpenSSL PHP extension');
        }
        if ( ! isset($this->allowedCiphers[$this->cipher][0], $this->allowedCiphers[$this->cipher][1])) {
            throw new InvalidConfigException($this->cipher . ' is not an allowed cipher');
        }

        list($blockSize, $keySize) = $this->allowedCiphers[$this->cipher];

        $keySalt = StringHelper::byteSubstr($data, 0, $keySize);
        if ($passwordBased) {
            $key = $this->pbkdf2($this->kdfHash, $secret, $keySalt, $this->derivationIterations, $keySize);
        } else {
            $key = $this->hkdf($this->kdfHash, $secret, $keySalt, $info, $keySize);
        }

        $authKey = $this->hkdf($this->kdfHash, $key, null, $this->authKeyInfo, $keySize);
        $data    = $this->validateData(StringHelper::byteSubstr($data, $keySize, null), $authKey);
        if ($data === false) {
            return false;
        }

        $iv        = StringHelper::byteSubstr($data, 0, $blockSize);
        $encrypted = StringHelper::byteSubstr($data, $blockSize, null);

        $decrypted = openssl_decrypt($encrypted, $this->cipher, $key, OPENSSL_KEYTYPE_RSA, $iv);
        if ($decrypted === false) {
            throw new Exception('OpenSSL failure on decryption: ' . openssl_error_string());
        }

        return $decrypted;
    }
}