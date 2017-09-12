<?php


namespace PaLabs\DatagridBundle\Util;


class StringUtils
{
    public static function startsWith($haystack, $needle, $strictCase = true)
    {
        if ($strictCase) {
            return strpos($haystack, $needle, 0) === 0;
        }
        return stripos($haystack, $needle, 0) === 0;
    }

    public static function startsWithAny($haystack, array $needles, $strictCase = true)
    {
        foreach ($needles as $needle) {
            if (self::startsWith($haystack, $needle, $strictCase)) {
                return true;
            }
        }
        return false;
    }

    public static function endsWith($haystack, $needle, $strictCase = true)
    {
        $expectedPosition = strlen($haystack) - strlen($needle);

        if ($strictCase) {
            return strrpos($haystack, $needle, 0) === $expectedPosition;
        }

        return strripos($haystack, $needle, 0) === $expectedPosition;
    }

    public static function contains($haystack, $needle)
    {
        return strpos($haystack, $needle) !== false;
    }

    /**
     * Camelizes a string.
     *
     * @param string $id A string to camelize
     *
     * @return string The camelized string
     */
    public static function camelize($id)
    {
        return strtr(ucwords(strtr($id, array('_' => ' ', '.' => '_ ', '\\' => '_ '))), array(' ' => ''));
    }

    /**
     * A string to underscore.
     *
     * @param string $id The string to underscore
     *
     * @return string The underscored string
     */
    public static function underscore($id)
    {
        return strtolower(preg_replace(['/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'], ['\\1_\\2', '\\1_\\2'], $id));
    }

    public static function utf8ForXml($string)
    {
        return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
    }

    public static function removeNewLineSymbols($string)
    {
        return str_replace(["\r", "\n"], "", $string);
    }

    public static function removeMultiSpaces($string)
    {
        return preg_replace('!\s+!', ' ', $string);
    }

    public static function trimStringArray(array $data)
    {
        return array_map(function ($item) {
            return trim($item);
        }, $data);
    }
}