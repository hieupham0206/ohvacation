<?php
/**
 * Created by PhpStorm.
 * User: Quang Hieu
 * Date: 9/11/2016
 * Time: 6:42 PM
 */

namespace common\utils\helpers;

use DateInterval;
use DatePeriod;
use DateTime;
use InvalidArgumentException;
use Yii;
use yii\base\InvalidConfigException;
use yii\i18n\PhpMessageSource;

class TimeHelper
{
    /**
     * @var array time intervals in seconds
     */
    public static $intervals = [
        'year'   => 31556926,
        'month'  => 2629744,
        'week'   => 604800,
        'day'    => 86400,
        'hour'   => 3600,
        'minute' => 60,
        'second' => 1
    ];

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
     * Get time elapsed (Facebook Style)
     *
     * @param string $fromTime start date time
     * @param bool $human if true returns an approximate human friendly output. If set to `false`, will attempt an
     *     exact conversion of time intervals.
     * @param string $toTime end date time (defaults to current system time)
     * @param string $append the string to append for the converted elapsed time. Defaults to ' ago'.
     *
     * Example Output(s):
     *     10 hours ago
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public static function getTimeElapsed($fromTime = null, $human = true, $toTime = null, $append = null)
    {
        static::initI18N();

        if ($fromTime != null) {
            $fromTime = strtotime($fromTime);
            $toTime   = ($toTime == null) ? time() : (int)$toTime;
        }

        return static::getTimeInterval($toTime - $fromTime, $append, $human);
    }

    /**
     * Get time interval (Facebook Style)
     *
     * @param int $interval time interval in seconds
     * @param string $append the string to append for the converted elapsed time. Defaults to ' ago'.
     * @param bool $human if true returns an approximate human friendly output. If set to `false`, will attempt an
     *     exact conversion of time intervals.
     *
     * Example Output(s):
     *     10 hours ago
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public static function getTimeInterval($interval, $append = null, $human = true)
    {
        static::initI18N();
        $intervals = static::$intervals;
        $elapsed   = '';

        if ($human) {
            if ($interval <= 0) {
                $elapsed = Yii::t('yii', 'a moment ago');
            } elseif ($interval < 60) {
                $elapsed = Yii::t('yii', '{n, plural, =1{a second} other{# seconds}} ago', ['n' => $interval]);
            } elseif ($interval >= 60 && $interval < $intervals['hour']) {
                $interval = floor($interval / $intervals['minute']);
                $elapsed  = Yii::t('yii', '{n, plural, =1{a minute} other{# minutes}} ago', ['n' => $interval]);
            } elseif ($interval >= $intervals['hour'] && $interval < $intervals['day']) {
                $interval = floor($interval / $intervals['hour']);
                $elapsed  = Yii::t('yii', '{n, plural, =1{an hour} other{# hours}} ago', ['n' => $interval]);
            } elseif ($interval >= $intervals['day'] && $interval < $intervals['week']) {
                $interval = floor($interval / $intervals['day']);
                $elapsed  = Yii::t('yii', '{n, plural, =1{a day} other{# days}} ago', ['n' => $interval]);
            } elseif ($interval >= $intervals['week'] && $interval < $intervals['month']) {
                $interval = floor($interval / $intervals['week']);
                $elapsed  = Yii::t('yii', '{n, plural, =1{a week} other{# weeks}} ago', ['n' => $interval]);
            } elseif ($interval >= $intervals['month'] && $interval < $intervals['year']) {
                $interval = floor($interval / $intervals['month']);
                $elapsed  = Yii::t('yii', '{n, plural, =1{a month} other{# months}} ago', ['n' => $interval]);
            } elseif ($interval >= $intervals['year']) {
                $interval = floor($interval / $intervals['year']);
                $elapsed  = Yii::t('yii', '{n, plural, =1{a year} other{# years}} ago', ['n' => $interval]);
            }
        } else {
            $elapsed = static::timeToString($interval, $intervals);
        }

        return $elapsed . $append;
    }

    /**
     * Get elapsed time converted to string
     *
     * Example Output:
     *    1 year 5 months 3 days ago
     *
     * @param int $time elapsed number of seconds
     * @param array $intervals configuration of time intervals in seconds
     *
     * @return string
     */
    protected static function timeToString($time, $intervals)
    {
        $output = '';
        foreach ($intervals as $name => $seconds) {
            $num  = floor($time / $seconds);
            $time -= ($num * $seconds);
            if ($num > 0) {
                $output .= $num . ' ' . $name . (($num > 1) ? 's' : '') . ' ';
            }
        }

        return trim($output);
    }

    /**
     * Generate list of months
     *
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    public static function generateMonths()
    {
        static::initI18N();

        return [
            1 => Yii::t('yii', 'January'),
            Yii::t('yii', 'February'),
            Yii::t('yii', 'March'),
            Yii::t('yii', 'April'),
            Yii::t('yii', 'May'),
            Yii::t('yii', 'June'),
            Yii::t('yii', 'July'),
            Yii::t('yii', 'August'),
            Yii::t('yii', 'September'),
            Yii::t('yii', 'October'),
            Yii::t('yii', 'November'),
            Yii::t('yii', 'December'),
        ];
    }

    /**
     * Generate list of days
     *
     * @return array
     * @throws \yii\base\InvalidParamException
     */
    public static function generateDays()
    {
        static::initI18N();

        return [
            1 => Yii::t('yii', 'Sunday'),
            Yii::t('yii', 'Monday'),
            Yii::t('yii', 'Tuesday'),
            Yii::t('yii', 'Wednesday'),
            Yii::t('yii', 'Thursday'),
            Yii::t('yii', 'Friday'),
            Yii::t('yii', 'Saturday')
        ];
    }

    /**
     * Generates a list of years
     *
     * @param integer $from the start year
     * @param integer $to the end year
     * @param boolean $keys whether to set the array keys same as the values (defaults to false)
     * @param boolean $desc whether to sort the years descending (defaults to true)
     *
     * @return array
     * @throws InvalidConfigException if $to < $from
     */
    public static function generateYearList($from, $to = null, $keys = false, $desc = true)
    {
        if (Inflector::isEmpty($to)) {
            $to = (int)date('Y');
        }
        if ($to >= $from) {
            $years = $desc ? range($to, $from) : range($from, $to);

            return $keys ? array_combine($years, $years) : $years;
        }

        throw new InvalidConfigException("The 'year to' parameter must exceed 'year from'.");
    }

    /**
     * Generate a month or day array list for Gregorian calendar
     *
     * @param string $unit whether 'day' or 'month'
     * @param bool $abbr whether to return abbreviated day or month
     * @param int $start the first day or month to set. Defaults to `1`.
     * @param string $case whether 'upper', lower', or null. If null, then the initcap case will be used.
     *
     * @return array list of days or months
     * @throws \yii\base\InvalidParamException
     * @throws InvalidConfigException
     */
    protected static function generateCalList($unit = 'day', $abbr = false, $start = 1, $case = null)
    {
        $source = $unit == 'month' ? static::generateMonths() : static::generateDays();
        $total  = count($source);
        if ($start < 1 || $start > $total) {
            throw new InvalidConfigException("The start '{$unit}' must be between 1 and {$total}.");
        }
        $converted = [];
        foreach ($source as $key => $value) {
            $data = $abbr ? substr($value, 0, 3) : $value;
            if ($case == 'upper') {
                $data = strtoupper($data);
            } elseif ($case == 'lower') {
                $data = strtolower($data);
            }
            if ($start == 1) {
                $i = $key;
            } else {
                $i = $key - $start + 1;
                if ($i < 1) {
                    $i += $total;
                }
            }
            $converted[$i] = $data;
        }

        return (ksort($converted) ? $converted : $source);
    }

    /**
     * Generate a month array list for Gregorian calendar
     *
     * @param bool $abbr whether to return abbreviated month
     * @param int $start the first month to set. Defaults to `1` for `January`.
     * @param string $case whether 'upper', lower', or null. If null, then the initcap case will be used.
     *
     * @return array list of months
     * @throws \yii\base\InvalidParamException
     * @throws InvalidConfigException
     */
    public static function generateMonthList($abbr = false, $start = 1, $case = null)
    {
        return static::generateCalList('month', $abbr, $start, $case);
    }

    /**
     * Generate a day array list for Gregorian calendar
     *
     * @param bool $abbr whether to return abbreviated day
     * @param int $start the first day to set. Defaults to `1` for `Sunday`.
     * @param string $case whether 'upper', lower', or null. If null, then the initcap case will be used.
     *
     * @return array list of days
     * @throws \yii\base\InvalidParamException
     * @throws InvalidConfigException
     */
    public static function generateDayList($abbr = false, $start = 1, $case = null)
    {
        return static::generateCalList('day', $abbr, $start, $case);
    }

    /** @noinspection MoreThanThreeArgumentsInspection */
    /**
     * Generate a date picker array list for Gregorian Calendar.
     *
     * @param int $from the start day, defaults to 1
     * @param int $to the end day, defaults to 31
     * @param int $interval the date interval, defaults to 1.
     * @param bool $intervalFromZero whether to start incrementing intervals from zero if $from = 1.
     * @param bool $showLast whether to show the last date (set in $to) even if it does not match interval.
     *
     * @return array
     * @throws InvalidConfigException
     */
    public static function generateDateList($from = 1, $to = 31, $interval = 1, $intervalFromZero = true, $showLast = true)
    {
        if ($to < 1 || $from < 1) {
            $val = $from < 1 ? "from day '{$from}'" : "to day '{$to}'";
            throw new InvalidConfigException("Invalid value for {$val} passed. Must be greater or equal than 1");
        }
        if ($from > $to) {
            throw new InvalidConfigException("The from day '{$from}' cannot exceed to day '{$to}'.");
        }
        if ($to > 31) {
            throw new InvalidConfigException("Invalid value for to day '{$to}' passed. Must be less than or equal to 31");
        }
        if ($from > 1 || $interval == 1 || ! $intervalFromZero) {
            $out = range($from, $to, $interval);
        } else {
            $out    = range(0, $to, $interval);
            $out[0] = 1;
        }
        $len = count($out);
        if ($showLast && $out[$len - 1] != $to) {
            $out[$len] = $to;
        }

        return $out;
    }

    /** @noinspection MoreThanThreeArgumentsInspection */
    /**
     * Generate a time picker array list
     *
     * @param string $unit the time unit ('hour', 'min', 'sec', 'ms')
     * @param integer $interval the time interval.
     * @param integer $from the time from (defaults to 23 for hour
     * @param integer $to the time to (defaults to 1).
     * @param bool $padZero whether to pad zeros to the left of each time unit value.
     *
     * @return array
     * @throws InvalidConfigException if $unit passed is invalid
     */
    public static function generateTimeList($unit, $interval = 1, $from = 0, $to = null, $padZero = true)
    {
        if ($unit == 'hour') {
            $maxTo = 23;
        } elseif ($unit == 'min' || $unit == 'sec') {
            $maxTo = 59;
        } elseif ($unit == 'ms') {
            $maxTo = 999;
        } else {
            throw new InvalidConfigException("Invalid time unit passed. Must be 'hour', 'min', 'sec', or 'ms'.");
        }
        if ($interval < 1) {
            throw new InvalidConfigException("Invalid time interval '{$interval}'. Must be greater than 0.");
        }
        if (empty($to)) {
            $to = $maxTo;
        }
        if ($to > $maxTo) {
            throw new InvalidConfigException("The '{$unit} to' cannot exceed {$maxTo}.");
        }
        if ($from < 0 || $from > $to) {
            throw new InvalidConfigException("The '{$unit} from' must lie between {$from} and {$to}.");
        }
        $data = range($from, $to, $interval);
        if ( ! $padZero) {
            return $data;
        }
        $out = [];
        $pad = strlen($maxTo . '');
        foreach ($data as $key => $value) {
            $out[$key] = str_pad($value, $pad, '0', STR_PAD_LEFT);
        }

        return $out;
    }

    /**
     * Returns total days of month
     *
     * @param int $month
     * @param int $year
     * @param int $calendar
     *
     * @return int Số ngày trong tháng
     * @throws InvalidArgumentException nếu tháng không hợp lệ
     */
    public static function getDayOfMonth($month = 0, $year = 0, $calendar = CAL_GREGORIAN)
    {
        if ($month > 12 || $month < 0 || ! is_int($month)) {
            throw new InvalidArgumentException('Tháng không hợp lệ');
        }
        $year  = $year == 0 ? date('Y') : $year;
        $month = $month == 0 ? date('m') : $month;

        return cal_days_in_month($calendar, $month, $year);
    }

    /**
     * Lấy ngày đầu tiên của tháng
     *
     * @param int $month
     * @param int $year
     *
     * @return false|int
     * @throws \InvalidArgumentException
     */
    public static function getFirstOfMonth($month = 0, $year = 0)
    {
        if ($month > 12 || $month < 0 || ! is_int($month)) {
            throw new InvalidArgumentException('Tháng không hợp lệ');
        }
        $year  = $year == 0 ? date('Y') : $year;
        $month = $month == 0 ? date('m') : $month;

        return mktime(0, 0, 0, $month, 1, $year);
    }

    /**
     * Lấy ngày cuối cùng của tháng
     *
     * @param int $month
     * @param int $year
     * @param int $calendar
     *
     * @return false|int
     * @throws \InvalidArgumentException
     */
    public static function getLastOfMonth($month = 0, $year = 0, $calendar = CAL_GREGORIAN)
    {
        if ($month > 12 || $month < 0 || ! is_int($month)) {
            throw new InvalidArgumentException('Tháng không hợp lệ');
        }
        $year  = $year == 0 ? date('Y') : $year;
        $month = $month == 0 ? date('m') : $month;

        $day = self::getDayOfMonth($month, $year, $calendar);

        return mktime(23, 59, 59, $month, $day, $year);
    }

    /**
     * Generate an array of string dates between 2 dates
     *
     * @param string $start Start date
     * @param string $end End date
     * @param string $format Output format (Default: Y-m-d)
     *
     * @return array
     * @throws \Exception
     */
    public static function getDatesFromRange($start, $end, $format = 'd-m-Y')
    {
        $array = array();
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        foreach($period as $date) {
            $array[] = $date->format($format);
        }

        return $array;
    }
}