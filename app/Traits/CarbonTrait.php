<?php
namespace App\Traits;

use DateTime;
use Carbon\Carbon;
use Respect\Validation\Validator as v;

trait CarbonTrait
{

    /**
     * Get Current date for specific time zone
     *
     * @param string  $timezone set time zone
     *
     * @return Carbon
     */
    public function getCurrentDate($timezone = 'America/Santiago'): Carbon
    {

        return Carbon::now($timezone);

    }

    /**
     * Get Current date for specific time zone
     *
     * @param DateTime  $date
     * @param string    $timezone set time zone
     *
     * @return Carbon
     */
    public function getDate(DateTime $date, $timezone = 'America/Santiago'): Carbon
    {

        return new Carbon($date, $timezone);

    }

    /**
     * Get format date
     *
     * @param Carbon  $date
     * @param string    $format
     * @param string    $timezone set time zone
     *
     * @return string
     */
    public function getFormatDate(DateTime $date, $format = 'd/m/Y H:i', $timezone = 'America/Santiago'): string
    {

        return $date->setTimezone($timezone)->format($format);

    }

    /**
     * Add hours to date
     *
     * @param Carbon  $date  time
     * @param int $hours
     *
     * @return Carbon
     */
    public function addHoursToDate(Carbon $date, int $hours): Carbon
    {

        return $date->addHours($hours);

    }

    /**
     * Add minutes to date
     *
     * @param Carbon  $date  time
     * @param int $minutes
     *
     * @return Carbon
     */
    public function addMinutesToDate(Carbon $date, int $minutes): Carbon
    {

        return $date->addMinutes($minutes);

    }

    /**
     * Add seconds to date
     *
     * @param Carbon  $date  time
     * @param int $seconds
     *
     * @return Carbon
     */
    public function addSecondsToDate(Carbon $date, int $seconds): Carbon
    {

        return $date->addSeconds($seconds);

    }

    /**
     * Add days to date
     *
     * @param Carbon  $date  time
     * @param int $days
     *
     * @return Carbon
     */
    public function addDaysToDate(Carbon $date, int $days): Carbon
    {

        return $date->addDays($days);

    }

    /**
     * Sub minutes to date
     *
     * @param Carbon  $date  time
     * @param int $minutes
     *
     * @return Carbon
     */
    public function subMinutesToDate(Carbon $date, int $minutes): Carbon
    {

        return $date->subMinutes($minutes);

    }

    /**
     * Sub hours to date
     *
     * @param Carbon  $date  time
     * @param int $hours
     *
     * @return Carbon
     */
    public function subHoursToDate(Carbon $date, int $hours): Carbon
    {

        return $date->subMinutes($hours);

    }

    /**
     * Sub seconds to date
     *
     * @param Carbon  $date  time
     * @param int $seconds
     *
     * @return Carbon
     */
    public function subSecondsToDate(Carbon $date, int $seconds): Carbon
    {

        return $date->subSeconds($seconds);

    }

    /**
     * Sub days to date
     *
     * @param Carbon  $date  time
     * @param int $days
     *
     * @return Carbon
     */
    public function subDaysToDate(Carbon $date, int $days): Carbon
    {

        return $date->subDays($days);

    }

}