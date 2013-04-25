<?php

namespace CybersExperts\Bundle\JalaliDateBundle\Service;

use CybersExperts\Bundle\JalaliDateBundle\Service\DateConverter;

/**
 * Description of DateConverter
 *
 * @author Hossein Zolfi (hossein.zolfi@gmail.com)
 */
class JalaliDateTime
{
    /**
     * @var DateConverter
     */
    var $dateConverter;

    public function __construct(DateConverter $dateConverter)
    {
        $this->dateConverter = $dateConverter;
    }

    /**
     * @return mixed of year, month, day
     */
    public function currentDate()
    {
        $timestamp = $this->getCurrentTime();
        return $this->dateConverter->timestampToJalali($timestamp);
    }

    public function getDayOfYear($year, $month, $day)
    {
        return $this->dateConverter->jalaliToJd($year, $month, $day) -
               $this->dateConverter->jalaliToJd($year, 1, 1) +
               1;
    }

    public function getWeekNumber($year, $month, $day)
    {
        $yearDay = $this->getDayOfYear($year, $month, $day);
        $firstDayWeekDay = $this->getWeekDayOfFirstDayOfYear($year);

        if ($firstDayWeekDay == 0) {
            $yearDay += 7;
        }

        $weekNumber = ($yearDay + $firstDayWeekDay - 1) / 7 | 0;
        if ($weekNumber > 0) {
            return array($year, $weekNumber);
        }

        $lastYear = $year - 1;
        $lastYearDay = 29;
        if ($this->isLeapYear($lastYear)) {
            $lastYearDay = 30;
        }
        return $this->getWeekNumber($lastYear, 12, $lastYearDay);
    }

    public function getWeekDayOfFirstDayOfYear($year)
    {
        $timestamp = $this->dateConverter->jalaliToTimestamp($year, 1, 1);
        $gregorianWeekDay = date('w', $timestamp);
        return ($gregorianWeekDay + 1) % 7;
    }

    public function isLeapYear($year)
    {
         if ($year > 0) {
             $rm = 474;
//         } else {
//             $rm = 473;
         }

         return (((((($year - $rm) % 2820) + 474) + 38) * 682) % 2816) < 682;
    }

    protected function getCurrentTime()
    {
        return time();
    }
}
