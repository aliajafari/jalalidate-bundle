<?php

namespace CybersExperts\Bundle\JalaliDateBundle\Tests\Service;

use CybersExperts\Bundle\JalaliDateBundle\Service\DateConverter;
use CybersExperts\Bundle\JalaliDateBundle\lib\JalaliDateConverter;

/**
 * Description of DateConverterTest
 *
 * @author ocean
 */
class DateConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateConverter
     */
    private $convrter;

    public function setUp() {
        $this->convrter = new DateConverter(new JalaliDateConverter());
    }

    /**
     * @dataProvider gregorianToJalaliDataProvider
     */
    public function testGregorianToJalali($input, $expected)
    {
        list($year, $month, $day) = $input;
        $this->assertEquals($this->convrter->gregorianToJalali($year, $month, $day), $expected);
    }

    /**
     * @dataProvider jalaliToGregorianToDataProvider
     */
    public function testJalaliToGregorian($input, $expected)
    {
        list($year, $month, $day) = $input;
        $this->assertEquals($this->convrter->jalaliToGregorian($year, $month, $day), $expected);
    }

    public function gregorianToJalaliDataProvider()
    {
        return array(
            array(array(2013, 4,  17), array(1392, 1, 28)),
            array(array(2013, 3,  20), array(1391, 12, 30)),
            array(array(2013, 3,  20), array(1391, 12, 30)),
        );
    }

    public function jalaliToGregorianToDataProvider()
    {
        $data = array();
        $gregorianToJalaliDates = $this->gregorianToJalaliDataProvider();
        foreach ($gregorianToJalaliDates as $gregorianToJalaliDate) {
            $data[] = array($gregorianToJalaliDate[1], $gregorianToJalaliDate[0]);
        }

        return $data;
    }

    /**
     * @dataProvider jalaliToJdDataProvider
     */
    public function testJalaliToJd($year, $month, $day, $expected)
    {
        $this->assertEquals($this->convrter->jalaliToJd($year, $month, $day), $expected);
    }

    public function jalaliToJdDataProvider()
    {
        return array(
            array(1392, 3,  5,  2456439),
            array(1392, 2,  2,  2456405),
            array(1391, 12, 30, 2456372),
            array(1392, 1,  1,  2456373),
            array(1391, 12, 1,  2456343),
        );
    }

    /**
     * @dataProvider jalaliToTimestampDataProvider
     */
    public function testJalaliToTimestamp($year, $month, $day, $expected)
    {
        $this->assertEquals($this->convrter->jalaliToTimestamp($year, $month, $day), $expected);
    }

    public function jalaliToTimestampDataProvider()
    {
        return array(
            array(1392, 3, 5, 1369510200),
        );
    }

    /**
     * @dataProvider jalaliToTimestampDataProvider
     */
    public function testTimestampToJalali($year, $month, $day, $timestamp)
    {
        $this->assertEquals($this->convrter->timestampToJalali($timestamp), array($year, $month, $day));
    }
}
