<?php
/**
 * Provided by Taha Kamkar, mainly to facilitate own works.
 * This is just a wrapper to enjoy Hashids more easily.
 */

namespace Hashids;

use Illuminate\Support\Str;

class Wrapper
{
    /**
     * switch the hashid string, supporting arrays.
     *
     * @param int|string|array $matter
     *
     * @return int|string|array|null
     */
    public static function idSwitch($matter)
    {
        if (is_numeric($matter)) {
            return static::idEncode($matter);
        }

        if (is_string($matter)) {
            return static::idDecode($matter);
        }

        if (is_array($matter)) {
            foreach ($matter as $key => $item) {
                $matter[$key] = static::idSwitch($item);
            }
            return $matter;
        }

        return null;
    }



    /**
     * encode hashid strings, supporting arrays.
     *
     * @param $matter
     *
     * @return string|array
     */
    public static function idEncode($matter)
    {
        if (static::shouldBypassHashidIds()) {
            return "h" . $matter;
        }

        if (is_string($matter)) {
            return $matter;
        }

        if (is_numeric($matter)) {
            return static::encode($matter);
        }

        if (is_array($matter)) {
            foreach ($matter as $key => $item) {
                $matter[$key] = static::idEncode($item);
            }
            return $matter;
        }

        return null;

    }



    /**
     * decode hashid strings, supporting arrays.
     *
     * @param $matter
     *
     * @return int|array|null
     */
    public static function idDecode($matter)
    {
        if (static::shouldBypassHashidIds()) {
            return (int)Str::after($matter, "h");
        }

        if (is_numeric($matter)) {
            return $matter;
        }

        if (is_string($matter)) {
            return static::decode($matter)[0];
        }

        if (is_array($matter)) {
            foreach ($matter as $key => $item) {
                $matter[$key] = static::idDecode($item);
            }
            return $matter;
        }

        return null;
    }



    /**
     * @param int|array $matter
     * @param string    $salt_name
     * @param int       $min_length
     * @param string    $alphabet
     *
     * @return string
     */
    public static function encode($matter, string $salt_name = "main", $min_length = 5, $alphabet = null)
    {
        return static::instance($salt_name, $min_length, $alphabet)->encode($matter);
    }



    /**
     * @param int    $matter
     * @param string $salt_name
     * @param int    $min_length
     * @param string $alphabet
     *
     * @return array
     */
    public static function decode(string $matter, string $salt_name = "main", $min_length = 5, $alphabet = null)
    {
        $decoded = static::instance($salt_name, $min_length, $alphabet)->decode($matter);

        return $decoded ?: [null];
    }



    /**
     * determine if the automatic hashid of ids should be bypassed. This is helpful in debug/development modes.
     *
     * @return bool
     */
    public static function shouldBypassHashidIds()
    {
        return config('hashids.bypass');
    }



    /**
     * get an instance of the hashid.
     *
     * @param string $salt_name
     * @param int    $min_length
     * @param null   $alphabet
     *
     * @return Hashids
     */
    private static function instance(string $salt_name = "main", $min_length = 5, $alphabet = null)
    {
        if (!$alphabet) {
            $alphabet = static::getDefaultAlphabet();
        }

        $salt = config("hashids.salt.$salt_name");

        return new Hashids($salt, $min_length, $alphabet);
    }



    /**
     * get default alphabet.
     *
     * @return string
     */
    private static function getDefaultAlphabet()
    {
        return "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }

}
