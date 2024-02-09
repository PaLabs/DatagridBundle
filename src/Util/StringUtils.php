<?php


namespace PaLabs\DatagridBundle\Util;


class StringUtils
{
    public static function startsWith($haystack, $needle, $strictCase = true): bool
    {
        if ($strictCase) {
            return strpos($haystack, $needle, 0) === 0;
        }
        return stripos($haystack, $needle, 0) === 0;
    }

    public static function startsWithAny($haystack, array $needles, $strictCase = true): bool
    {
        foreach ($needles as $needle) {
            if (self::startsWith($haystack, $needle, $strictCase)) {
                return true;
            }
        }
        return false;
    }

    public static function endsWith($haystack, $needle, $strictCase = true): bool
    {
        $expectedPosition = strlen($haystack) - strlen($needle);

        if ($strictCase) {
            return strrpos($haystack, $needle, 0) === $expectedPosition;
        }

        return strripos($haystack, $needle, 0) === $expectedPosition;
    }

    public static function contains($haystack, $needle): bool
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
    public static function camelize(string $id): string
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
    public static function underscore(string $id): string
    {
        return strtolower(preg_replace(['/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'], ['\\1_\\2', '\\1_\\2'], $id));
    }

    public static function trimStringArray(array $data): array
    {
        return array_map(fn($item) => trim($item), $data);
    }

    public static function fixEncoding($line)
    {
        //reject overly long 2 byte sequences, as well as characters above U+10000 and replace with ?
        $line = preg_replace('/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]' .
            '|[\x00-\x7F][\x80-\xBF]+' .
            '|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*' .
            '|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})' .
            '|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
            '?', $line);

        //reject overly long 3 byte sequences and UTF-16 surrogates and replace with ?
        $line = preg_replace('/\xE0[\x80-\x9F][\x80-\xBF]' .
            '|\xED[\xA0-\xBF][\x80-\xBF]/S', '?', $line);
        return $line;
    }

}