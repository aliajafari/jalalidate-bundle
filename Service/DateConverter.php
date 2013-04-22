<?php

namespace CybersExperts\Bundle\JalaliDateBundle\Service;

use CybersExperts\Bundle\JalaliDateBundle\lib\JalaliDateConverter;

/**
 * Description of DateConverter
 *
 * @author Hossein Zolfi (hossein.zolfi@gmail.com)
 */
class DateConverter
{
    /**
     * @var JalaliDateConverter
     */
    var $dateConverter;

    public function __construct(JalaliDateConverter $dateConverter)
    {
        $this->dateConverter = $dateConverter;
    }

    /**
     *
     * @param integer $year     gregorian year
     * @param integer $month    gregorian month
     * @param integer $day      gregorian day
     * @return mixed            array of year, month, day
     */
    public function gregorianToJalali($year, $month, $day)
    {
        return $this->dateConverter->gregorian_to_jalali($year, $month, $day);
    }

    /**
     *
     * @param  $year
     * @param type $month
     * @param type $day
     * @return type
     */
    public function jalaliToGregorian($year, $month, $day)
    {
        return $this->dateConverter->jalali_to_gregorian($year, $month, $day);
    }

    /**
     *
     * @param  $year
     * @param type $month
     * @param type $day
     * @return type
     */
    public function jalaliToJd($year, $month, $day)
    {
        list($gregorianYear, $gregorianMonth, $gregorianDay) = $this->jalaliToGregorian($year, $month, $day);

        return gregoriantojd($gregorianMonth, $gregorianDay, $gregorianYear);
    }

    /**
     *
     * @param  $year
     * @param type $month
     * @param type $day
     * @return type
     */
    public function jalaliToTimestamp($year, $month, $day)
    {
        list($year, $month, $day) = $this->jalaliToGregorian($year, $month, $day);

        return mktime(0, 0, 0, $month, $day, $year);
    }
}
