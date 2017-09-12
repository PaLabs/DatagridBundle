<?php


namespace PaLabs\DatagridBundle\Util;


class DateUtils {

    /**
     * @return int
     */
    public static function currentYear() {
        return (int) date('Y');
    }

    public static function year(\DateTime $date) {
        return (int) $date->format('Y');
    }

    public static function localizedDate(\DateTime $date = null) {
        return \IntlDateFormatter::create('ru', \IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE)
            ->format($date);
    }

    public static function localizedDateTime(\DateTime $date = null) {
        return \IntlDateFormatter::create('ru', \IntlDateFormatter::MEDIUM, \IntlDateFormatter::MEDIUM)
            ->format($date);
    }

    public static function localizedDateNow(\DateTime $date = null) {
        if($date === null) {
            return 'настоящее время';
        }
        return self::localizedDate($date);
    }

}