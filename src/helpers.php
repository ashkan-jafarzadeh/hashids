<?php

use Hashids\Wrapper as Hashid;

if (!function_exists("hashid")) {
    /**
     * switch the hashid string.
     *
     * @param int|string|array $matter
     *
     * @return int|string|array
     */
    function hashid($matter)
    {
        return Hashid::idSwitch($matter);
    }
}

if (!function_exists("hashid_number")) {
    /**
     * decode hashid strings, supporting arrays.
     *
     * @param $matter
     *
     * @return int|array|null
     */
    function hashid_number($matter)
    {
        return Hashid::idDecode($matter);
    }
}

if (!function_exists("hashid_string")) {
    /**
     * encode hashid strings, supporting arrays.
     *
     * @param $matter
     *
     * @return string|array
     */
    function hashid_string($matter)
    {
        return Hashid::idEncode($matter);
    }
}

if (!function_exists("is_hashid")) {
    /**
     * check if the given string is a valid hashid encrypted string. This cannot be used as a validation rule.
     *
     * @param string|int $matter
     *
     * @return boolean
     */
    function is_hashid($matter)
    {
        if (is_numeric($matter) or is_array($matter) or is_object($matter)) {
            return false;
        }

        return is_numeric(hashid($matter));
    }
}
