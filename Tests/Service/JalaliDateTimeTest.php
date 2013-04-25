<?php

namespace CybersExperts\Bundle\JalaliDateBundle\Tests\Service;

use CybersExperts\Bundle\JalaliDateBundle\Service\DateConverter;
use CybersExperts\Bundle\JalaliDateBundle\Service\JalaliDateTime;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Description of DateConverterTest
 *
 * @author ocean
 */
class JalaliDateTimeTest extends WebTestCase
{
    public function testCurrentDate()
    {
        $currentTimestamp = 1366412400;
        $result = array(1392, 1, 19);

        $dateConverter = $this->getMockBuilder('\CybersExperts\Bundle\JalaliDateBundle\Service\DateConverter')
                ->disableOriginalConstructor()
                ->getMock();
        $jalaliDateTime = $this->getMockBuilder('\CybersExperts\Bundle\JalaliDateBundle\Service\JalaliDateTime')
                ->setMethods(array('getCurrentTime'))
                ->setConstructorArgs(array($dateConverter))
                ->getMock();
        $jalaliDateTime
                ->expects($this->once())
                ->method('getCurrentTime')
                ->will($this->returnValue($currentTimestamp));

        $dateConverter
                ->expects($this->once())
                ->method('timestampToJalali')
                ->with($currentTimestamp)
                ->will($this->returnValue($result));

        $this->assertEquals($jalaliDateTime->currentDate(), $result);
    }

    public function testGetGregorian()
    {
        $dateConverter = $this->getMockBuilder('\CybersExperts\Bundle\JalaliDateBundle\Service\DateConverter')
                ->setMethods(array('gregorianToJalali'))
                ->disableOriginalConstructor()
                ->getMock();
        $jalaliDateTime = $this->getMockBuilder('\CybersExperts\Bundle\JalaliDateBundle\Service\JalaliDateTime')
                ->setConstructorArgs(array($dateConverter))
                ->setMethods(null)
                ->getMock();

        $dateConverter
                ->expects($this->once())
                ->method('gregorianToJalali')
                ->with($this->greaterThanOrEqual(2013), $this->greaterThanOrEqual(1), $this->greaterThanOrEqual(1));

        $jalaliDateTime->currentDate();
    }

    /**
     * @dataProvider getDayOfYearDataProvider
     */
    public function testGetDayOfYear($year, $month, $day, $jd1, $jd2, $expected)
    {
        $dateConverter = $this->getMockBuilder('\CybersExperts\Bundle\JalaliDateBundle\Service\DateConverter')
                ->disableOriginalConstructor()
                ->setMethods(array('jalaliToJd'))
                ->getMock();

        $dateConverter
                ->expects($this->at(0))
                ->method('jalaliToJd')
                ->with($year, $month, $day)
                ->will($this->returnValue($jd1));

        $dateConverter
                ->expects($this->at(1))
                ->method('jalaliToJd')
                ->with($year, 1, 1)
                ->will($this->returnValue($jd2));

        $jalaliDateTime = new JalaliDateTime($dateConverter);
        $this->assertEquals($jalaliDateTime->getDayOfYear($year, $month, $day), $expected);
    }

    public function getDayOfYearDataProvider()
    {
        return array(
            array(1392, 3,  5,  2456439, 2456373, 67),
            array(1392, 2,  2,  2456405, 2456373, 33),
            array(1391, 12, 30, 2456372, 2456007, 366),
        );
    }

    /**
     * @dataProvider getWeekNumberDataProvider
     */
    public function testGetWeekNumber($year, $month, $day, $expected)
    {
        $jalaliDateTime = $this->getContainer()->get('ce.jalali_date.date_time');
        $this->assertEquals($jalaliDateTime->getWeekNumber($year, $month, $day), $expected);
    }

    public function getWeekNumberDataProvider()
    {
        return array(
            array(1354, 1,  1,  array(1353, 52)), // Jom
            array(1354, 1,  2,  array(1354, 1)),  // Shn
            array(1354, 1,  8,  array(1354, 1)),  // Jom
            array(1354, 1,  9,  array(1354, 2)),  // Shn

            array(1354, 12, 30, array(1354, 53)), // Shn
            array(1355, 1,  1,  array(1354, 53)), // 1sh
            array(1355, 1,  6,  array(1354, 53)), // 1sh
            array(1355, 1,  7,  array(1355, 1)), // 1sh

            array(1391, 12, 30, array(1391, 52)), // 4sh
            array(1392, 1,  1,  array(1391, 52)), // 5sh
            array(1392, 1,  3,  array(1392, 1)),  // Shn
            array(1392, 1,  9,  array(1392, 1)),  // Jom
            array(1392, 1,  10,  array(1392, 2)),  // Shn

            array(1392, 3,  5,  array(1392, 10)),
            array(1392, 2,  2,  array(1392, 5)),
            array(1392, 11, 4,  array(1392, 44)),

            array(1393, 1,  1,  array(1392, 52)), // Jom
            array(1394, 1,  1,  array(1394, 1)),  // Shn
            array(1394, 1,  3,  array(1394, 1)),  // 2sh
            array(1394, 1,  7,  array(1394, 1)),  // Jom
            array(1394, 1,  8,  array(1394, 2)),  // Shn
        );
    }

    /**
     * @dataProvider getWeekDayOfFirstDayOfYearDataProvider
     * @param type $year
     * @param type $expected
     */
    public function testGetWeekDayOfFirstDayOfYear($year, $expected)
    {
        $jalaliDateTime = $this->getContainer()->get('ce.jalali_date.date_time');
        $this->assertEquals($jalaliDateTime->getWeekDayOfFirstDayOfYear($year), $expected);
    }

    public function getWeekDayOfFirstDayOfYearDataProvider()
    {
        return array(
            array(1392, 5),
            array(1391, 3),
            array(1387, 5),
        );
    }

    /**
     * @dataProvider isLeapYearDataProvider
     * @param type $year
     * @param type $expected
     */
    public function testIsLeapYear($year, $expected)
    {
        $jalaliDateTime = $this->getContainer()->get('ce.jalali_date.date_time');
        $this->assertEquals($jalaliDateTime->isLeapYear($year), $expected);
    }

    public function isLeapYearDataProvider()
    {
        return array(
            array(1392, false),
            array(1391, true),
            array(1387, true),
            array(1354, true),
        );
    }
}
