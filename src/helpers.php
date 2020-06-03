<?php

use Hashids\Wrapper as Hashid;

if (!function_exists("hashid")) {
    /**
     * switch the hashid string.
     *
     * @param int|string|array $matter
     * @param string           $salt_name
     *
     * @return int|string|array
     */
    function hashid($matter, string $salt_name = "main")
    {
        return Hashid::idSwitch($matter, $salt_name);
    }
}

if (!function_exists("hashid_number")) {
    /**
     * decode hashid strings, supporting arrays.
     *
     * @param int|string|array $matter
     * @param string           $salt_name
     *
     * @return int|array|null
     */
    function hashid_number($matter, string $salt_name = "main")
    {
        return Hashid::idDecode($matter, $salt_name);
    }
}

if (!function_exists("hashid_string")) {
    /**
     * encode hashid strings, supporting arrays.
     *
     * @param int|string|array $matter
     * @param string           $salt_name
     *
     * @return string|array
     */
    function hashid_string($matter, string $salt_name = "main")
    {
        return Hashid::idEncode($matter, $salt_name);
    }
}

if (!function_exists("is_hashid")) {
    /**
     * check if the given string is a valid hashid encrypted string. This cannot be used as a validation rule.
     *
     * @param string|int $matter
     * @param string     $salt_name
     *
     * @return boolean
     */
    function is_hashid($matter, string $salt_name = "main")
    {
        if (is_numeric($matter) or is_array($matter) or is_object($matter)) {
            return false;
        }

        return is_numeric(hashid($matter, $salt_name));
    }
}
