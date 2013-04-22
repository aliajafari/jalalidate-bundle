jalalidate-bundle
=================

Bundle for working with jalali date

Installation
------------

Using [Composer](http://getcomposer.org), just require the `ce/jalali-date-bundle`
package:

``` javascript
{
    "require": {
        "ce/jalali-date-bundle": "@dev-master"
    }
}
```

Otherwise, install the library and setup the autoloader yourself.

Usage
-----

This library is under development. At this time, there is tow developed services.

### JalaliDateTime

For working with Jalali date. You can use this services by getting the service and
then calling provided methods.

``` php
<?php

// In your action of controller
$jalaliDatetime = $this->get('ce.jalali_date.date_time');
$jalaliDatetime->currentDate();  // return (1392, 2, 7) for example
$jalaliDatetime->getDayOfYear(1392, 11, 4);  // Getting the number of passed days
$jalaliDatetime->getWeekNumber(1392, 11, 4); // Getting the number of passed weeks
$jalaliDatetime->getWeekDayOfFirstDayOfYear(1392); // 0 for Saturday and 6 for Friday

 ```

### DateConverter

For converting Jalali to gregorian date and vice versa. You can use this services
by getting the service and then calling provided methods.

``` php
<?php

// In your action of controller
$jalaliDatetime = $this->get('ce.jalali_date.date_converter');
$jalaliDatetime->gregorianToJalali(2013, 1, 27); // Convert gregorian date to jalali
$jalaliDatetime->jalaliToGregorian(1392, 11, 4); // Convert jalali date to gregorian
$jalaliDatetime->jalaliToJd(1392, 11, 4); // Convert jalali date to julian
$jalaliDatetime->jalaliToTimestamp(1392, 11, 4); // Getting timestamp of jalali date

 ```

### Test

This bundle is fully tested.


License
-------

JalaliDateBundle is released under the MIT License. See the bundled LICENSE file for details.
