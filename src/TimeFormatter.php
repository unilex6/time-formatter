<?php

namespace TimeFormatter;

/**
 * Class TimeFormatter
 * @package TimeFormatter
 */
class TimeFormatter
{
    const LOCALE_RUS = 'ru-RU';
    const LOCALE_EN = 'en-US';

    protected static $locale;
    protected static $messagesCache;

    /**
     * @param $timestamp
     * @param array $options
     * @return string
     */
    public static function time($timestamp, array $options = [])
    {
        $result = '';

        $locale = (isset($options['locale']) && $options['locale']) ? $options['locale'] : self::LOCALE_RUS;
        self::setLocale($locale);

        if (is_int($timestamp))
            $unixTimestamp = $timestamp;
        elseif ($timestamp == ((string)(int) $timestamp))
            $unixTimestamp = $timestamp;
        else
            $unixTimestamp = strtotime($timestamp);

        if (!$unixTimestamp)
            return $result;

        $thisDay = (int) date('d');
        $thisMonth = (int) date('m');
        $thisYear = (int) date('Y');

        $day = (int) date('d', $unixTimestamp);
        $month = (int) date('m', $unixTimestamp);
        $monthStr = self::prepareMonth($month);
        $year = (int) date('Y', $unixTimestamp);
        $hours = date('H', $unixTimestamp);
        $minutes = date('i', $unixTimestamp);

        if ((isset($options['with_time']) && !$options['with_time']) === false)
            $result = self::t('at', 'words') . ' ' . $hours . ':' . $minutes;

        if (isset($options['year_required']) && $options['year_required'])
            return $day . ' ' . $monthStr . ' ' . $year . ' ' . $result;

        // If requested year is the same as current
        if ($thisYear == $year) {
            // If requested month is the same as current
            if ($thisMonth == $month) {
                if ($thisDay == $day)
                    $result = mb_convert_case(self::t('today', 'words'), MB_CASE_TITLE) . ' ' . $result;
                elseif ($thisDay == $day + 1)
                    $result = mb_convert_case(self::t('yesterday', 'words'), MB_CASE_TITLE) . ' ' . $result;
                else
                    $result = $day . ' ' . $monthStr . ' ' . $result;
            } else
                $result = $day . ' ' . $monthStr . ' ' . $result;

            return $result;
        }

        $result = $day . ' ' . $monthStr . ' ' . $year . ' ' . $result;

        return $result;
    }

    /**
     * @param $locale
     */
    protected static function setLocale($locale)
    {
        self::$locale = $locale;
    }

    /**
     * @param int $number
     * @return string
     */
    protected function prepareMonth($number)
    {
        switch ($number) {
            case 1:
                return self::t('january', 'months-short');
            case 2:
                return self::t('february', 'months-short');
            case 3:
                return self::t('march', 'months-short');
            case 4:
                return self::t('april', 'months-short');
            case 5:
                return self::t('may', 'months-short');
            case 6:
                return self::t('june', 'months-short');
            case 7:
                return self::t('july', 'months-short');
            case 8:
                return self::t('august', 'months-short');
            case 9:
                return self::t('september', 'months-short');
            case 10:
                return self::t('october', 'months-short');
            case 11:
                return self::t('november', 'months-short');
            case 12:
                return self::t('december', 'months-short');
        }
    }

    /**
     * @param $item
     * @param $message
     * @param null $locale
     * @return mixed
     */
    static protected function t($item, $message, $locale = null)
    {
        $locale = $locale ?: self::$locale;
        $messagePath = __DIR__ . "/messages/{$locale}/{$message}.php";

        if (!isset(self::$messagesCache[$locale][$message])) {
            $messages = file_exists($messagePath) ? require_once($messagePath) : [];
            self::$messagesCache[$locale][$message] = $messages;
        }

        $messages = &self::$messagesCache[$locale][$message];

        return isset($messages[$item]) ? $messages[$item] : $item;
    }
}