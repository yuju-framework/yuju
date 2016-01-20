<?php
/**
 * Date Object
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Date Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Date
{
    const SECONDS=0;
    const MINUTES=1;
    const HOURS=2;
    const DAYS=3;
    const MONTH=4;
    const YEARS=5;

    /**
     * Day
     *
     * @var    int
     * @access private
     */
    private $day;

    /**
     * Month
     *
     * @var    int
     * @access private
     */
    private $month;

    /**
     * Year
     *
     * @var    int
     * @access private
     */
    private $year;

    /**
     * Hour
     *
     * @var    int
     * @access private
     */
    private $hour;

    /**
     * Minutes
     *
     * @var    int
     * @access private
     */
    private $minutes;

    /**
     * Seconds
     *
     * @var    int
     * @access private
     */
    private $seconds;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->setNull();
    }

    /**
     * Date to Data Base format YYYYMMDD
     *
     * @access public
     * @return string
     */
    public function dateToDB()
    {
        if ($this->day !="" && $this->month !="" && $this->year !="") {
            return "'".$this->year.sprintf("%02s", $this->month).
                sprintf("%02s", $this->day)."'";
        } else {
            return 'NULL';
        }
    }

    /**
     * Determines empty date
     *
     * @return boolean
     */
    public function isDateEmpty()
    {
        if ($this->dateToDB()=='NULL') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get date and time to database format
     *
     * @return string
     */
    public function dateTimeToDB()
    {
        if ($this->day !=="" && $this->month !==""
            && $this->year !=="" && $this->hour !==""
            && $this->minutes !=="" && $this->seconds !==""
        ) {
            return "'".$this->year.sprintf("%02s", $this->month).
                sprintf("%02s", $this->day).sprintf("%02s", $this->hour).
                sprintf("%02s", $this->minutes).
                sprintf("%02s", $this->seconds)."'";
        } else {
            return "NULL";
        }
    }

    /**
     * Time to database format
     *
     * @return string
     */
    public function timeToDB()
    {
        if ($this->hour !== ""
            && $this->minutes !== ""
            && $this->seconds !== ""
        ) {
            return "'".sprintf("%02s", $this->hour).
                sprintf("%02s", $this->minutes).
                sprintf("%02s", $this->seconds)."'";
        } else {
            return "NULL";
        }
    }

    /**
     * Determine if empty date and time
     *
     * @return boolean
     */
    public function isDateTimeEmpty()
    {
        if ($this->dateTimeToDB() == 'NULL') {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Determine if empty time
     *
     * @return boolean
     */
    public function isTimeEmpty()
    {
        if ($this->timeToDB() == 'NULL') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set null values
     *
     * @return void
     */
    public function setNull()
    {
        $this->day     = '';
        $this->month   = '';
        $this->year    = '';
        $this->hour    = '';
        $this->minutes = '';
        $this->seconds = '';
    }

    /**
     * Set date
     *
     * @param integer $day   day
     * @param integer $month month
     * @param integer $year  year
     *
     * @return boolean
     */
    public function setDate($day, $month, $year)
    {
        if ($day=='00' && $month=='00' && $year=='0000') {
            $this->day='00';
            $this->month='00';
            $this->year='0000';
            return true;
        }
        if (!is_numeric($day) || $day==""
            || !is_numeric($month) || $month==""
            || $year=="" || !is_numeric($year)
        ) {
            return false;
        }
        if (!checkdate($month, $day, $year)) {
            return false;
        }
        $this->setDay($day);
        $this->setMonth($month);
        $this->setYear($year);
        return true;
    }

    public function setDateFormat($date)
    {
        if ($date=='' || $date===null) {
            $this->setNull();
            return true;
        }
        // Format "YYYY-MM-DDTHH:MM:SS+ZZ:ZZ"
        $match = "/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})T";
        $match.= "([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})\+([0-9]{1,2}):([0-9]{1,2})/";
        if (preg_match($match, $date, $regs)) {
            $this->seconds=$regs[6];
            $this->minutes=$regs[5];
            $this->hour=$regs[4];
            $this->day=$regs[3];
            $this->month=$regs[2];
            $this->year=$regs[1];
            return true;
        }
        // Format "YYYY-MM-DDTHH:MM:SS.XXXZ"
        $match = "/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})T";
        $match.= "([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})\.([0-9]{1,3})Z/";
        if (preg_match($match, $date, $regs)) {
            $this->seconds=$regs[6];
            $this->minutes=$regs[5];
            $this->hour=$regs[4];
            $this->day=$regs[3];
            $this->month=$regs[2];
            $this->year=$regs[1];
            return true;
        }
        return false;
    }

    /**
     * Set date and time
     *
     * @param integer $day     day
     * @param integer $month   month
     * @param integer $year    year
     * @param integer $hour    hour
     * @param integer $minutes minutes
     * @param integer $seconds seconds
     *
     * @return boolean
     */
    public function setDateTime($day, $month, $year, $hour, $minutes, $seconds)
    {
        if ($day=='00' && $month=='00' && $year=='0000') {
            $this->day='00';
            $this->month='00';
            $this->year='0000';
            $this->hour='00';
            $this->minutes='00';
            $this->seconds='00';
            return true;
        }
        if (checkdate($month, $day, $year)
            && (($hour==0 || $hour==00)
            || ($minutes==0 || $minutes==00)
            || ($seconds==0 || $seconds==00))
        ) {
            $this->setDay($day);
            $this->setMonth($month);
            $this->setYear($year);
            $this->setHour($hour);
            $this->setMinutes($minutes);
            $this->setSeconds($seconds);
            return true;
        }
        if (!is_numeric($day) || $day==""
            || !is_numeric($month) || $month==""
            || $year=="" || !is_numeric($year)
            || !is_numeric($hour) || $hour==""
            || !is_numeric($minutes) || $minutes==""
            || !is_numeric($seconds) || $seconds==""
        ) {
            return false;
        }
        if (!checkdate($month, $day, $year)) {
            return false;
        }
        $this->setDay($day);
        $this->setMonth($month);
        $this->setYear($year);
        $this->setHour($hour);
        $this->setMinutes($minutes);
        $this->setSeconds($seconds);
        return true;
    }

    public function toISO8601()
    {
        if ($this->showDate()=='') {
            return '';
        }
        return date(
            'c',
            mktime(
                (int)$this->hour,
                (int)$this->minutes,
                (int)$this->seconds,
                (int)$this->month,
                (int)$this->day,
                (int)$this->year
            )
        );
    }

    /**
     * Get ages
     *
     * @param sring $var date
     *
     * @return integer
     */
    public function getAge($var = '')
    {
        if ($var=='') {
            // We estimate the date to the object
            $year=$this->year;
            $month=$this->month;
            $year=$this->day;
        } else {
            // We estimate the parameters entered date
            // Format: DD-MM-AAAA
            // TODO: Check date with regex
            $year=substr($var, 6, 4);
            $month=substr($var, 3, 2);
            $day=substr($var, 0, 2);
        }
        if (($month < date("m")) || (($day <= date("d")) && ($month==date("m")))) {
            // If the last birthday already this year
            $age = date("Y") - $year;
        } else {
            // If the last birthday has not been this year
            $age= date("Y") - $year - 1 ;
        }
        return $age;
    }

    /**
     * Getter month
     *
     * @return string
     */
    public function getMonth()
    {
        return sprintf("%02s", $this->month);
    }

    /**
     * Getter year
     *
     * @return number
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Getter day
     *
     * @return string
     */
    public function getDay()
    {
        return sprintf("%02s", $this->day);
    }

    /**
     * Setter month
     *
     * @param integer $val month
     *
     * @return void
     */
    public function setMonth($val)
    {
        $this->month=$val;
    }

    /**
     * Setter year
     *
     * @param integer $val year
     *
     * @return void
     */
    public function setYear($val)
    {
        $this->year=$val;
    }

    /**
     * Setter day
     *
     * @param integer $val day
     *
     * @return void
     */
    public function setDay($val)
    {
        $this->day=$val;
    }

    /**
     * Setter hour
     *
     * @param integer $val hour
     *
     * @return void
     */
    public function setHour($val)
    {
        $this->hour=$val;
    }

    /**
     * Setter minutes
     *
     * @param integer $val minutes
     *
     * @return void
     */
    public function setMinutes($val)
    {
        $this->minutes=$val;
    }

    /**
     * Setter seconds
     *
     * @param integer $val seconds
     *
     * @return void
     */
    public function setSeconds($val)
    {
        $this->seconds=$val;
    }

    /**
     * Getter hour
     *
     * @return string
     */
    public function getHour()
    {
        return sprintf("%02s", $this->hour);
    }

    /**
     * Getter minutes
     *
     * @return string
     */
    public function getMinutes()
    {
        return sprintf("%02s", $this->minutes);
    }

    /**
     * Getter seconds
     *
     * @return string
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * Determine if present date
     *
     * @return boolean
     */
    public function isActually()
    {
        if ($this->day =="00" && $this->month =="00" && $this->year =="0000") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set date and time from database format
     *
     * @param string $date date
     *
     * @return boolean
     */
    public function setDateTimeFromDB($date)
    {
        if ($date=='') {
            return true;
        }
        $match = "/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})";
        $match.= " ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/";
        if (preg_match($match, $date, $regs)) {
            $this->seconds=$regs[6];
            $this->minutes=$regs[5];
            $this->hour=$regs[4];
            $this->setDay($regs[3]);
            $this->setMonth($regs[2]);
            $this->setYear($regs[1]);
            return true;
        } else {
            return false;
        }
    }


    /**
     * Set date from database format
     *
     * @param string $date date
     *
     * @return boolean
     */
    public function setDateFromDB($date)
    {
        if ($date=='') {
            return true;
        }

        $data_format1 = "/([0-9]{4})[-|\/]([0-9]{1,2})[-|\/]([0-9]{1,2})/";
        $data_format2 = "/([0-9]{1,2})[-|\/]([0-9]{1,2})[-|\/]([0-9]{4})/";
        if (preg_match($data_format1, $date, $regs)) {
            if (checkdate($regs[2], $regs[3], $regs[1])) {
                $this->setDay($regs[3]);
                $this->setMonth($regs[2]);
                $this->setYear($regs[1]);
                return true;
            }
        } elseif (preg_match($data_format2, $date, $regs)) {
            if (checkdate($regs[2], $regs[1], $regs[3])) {
                $this->setDay($regs[1]);
                $this->setMonth($regs[2]);
                $this->setYear($regs[3]);
                return true;
            }
        }
        return false;
    }

    /**
     * Set actual date
     *
     * @return void
     */
    public function setNow()
    {
        $date=getdate();
        $this->day     = $date['mday'];
        $this->month   = $date['mon'];
        $this->year    = $date['year'];
        $this->hour    = $date['hours'];
        $this->minutes = $date['minutes'];
        $this->seconds = $date['seconds'];
    }

    /**
     * Get present date and time by name
     *
     * @todo return english format
     *
     * @return string
     */
    public function getPresentDateTimeByName()
    {
        $date=getdate();
        $this->day     = $date['mday'];
        $this->month   = $date['mon'];
        $this->year    = $date['year'];
        $this->hour    = $date['hours'];
        $this->minutes = $date['minutes'];
        $this->seconds = $date['seconds'];
        return $this->day." de ".Date::getMonthName($this->month)." de ".
            $this->year." ".
            sprintf("%02s", $this->hour).":".
            sprintf("%02s", $this->minutes).":".
            sprintf("%02s", $this->seconds);
    }

    /**
     * Get present date and time to database format
     *
     * @return string
     */
    public static function getPresentDateTimeToDB()
    {
        $date=getdate();
        return $date['year'].
            sprintf("%02s", $date['mon']).$date['mon'].$date['mday'];
    }

    /**
     * Get present date
     *
     * @return string
     */
    public static function getPresentDate()
    {
        $date=getdate();
        return str_pad($date['mday'], 2, '0', STR_PAD_LEFT).
            '/'.str_pad($date['mon'], 2, '0', STR_PAD_LEFT).'/'.$date['year'];
    }

    /**
     * Set time
     *
     * @param string $date time
     *
     * @return boolean
     */
    public function setTime($date)
    {
        if ($date=='') {
            return true;
        }
        if (preg_match("/([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $date, $regs)) {
            $this->seconds=$regs[3];
            $this->minutes=$regs[2];
            $this->hour=$regs[1];
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set present date
     *
     * @return void
     */
    public function setPresentDate()
    {
        $date=getdate();
        $this->day     = sprintf("%02s", $date['mday']);
        $this->month   = sprintf("%02s", $date['mon']);
        $this->year    = $date['year'];
        $this->hour    = sprintf("%02s", $date['hours']);
        $this->minutes = sprintf("%02s", $date['minutes']);
        $this->seconds = sprintf("%02s", $date['seconds']);
    }

    /**
     * Show date
     *
     * @param string $separator seperator
     *
     * @return string
     */
    public function showDate($separator = '/')
    {
        if ($this->day !="" && $this->month !="" && $this->year !="") {
            if ($this->isActually()) {
                return _('Actually');
            } else {
                return $this->day.$separator.$this->month.$separator.$this->year;
            }
        }
    }

    /**
     * Show date and time
     *
     * @return string
     */
    public function showDateTime()
    {
        if ($this->day !="" && $this->month !="" && $this->year !=""
            && $this->hour !="" && $this->minutes !="" && $this->seconds !=""
        ) {
            if ($this->day =="00" && $this->month =="00" && $this->year =="0000"
                && $this->hour =="00" && $this->minutes =="00"
                && $this->seconds =="00"
            ) {
                return _('Actually');
            } else {
                return sprintf("%02s", $this->day)."/".
                    sprintf("%02s", $this->month)."/".sprintf("%02s", $this->year).
                    " ".$this->hour.":".$this->minutes.":".$this->seconds;
            }
        }
    }

    /**
     * Show hour
     *
     * @param string  $separator   string separatos. By default ":"
     * @param boolean $showseconds determina si muestra o no los segundos.
     *                             Por defecto sí
     *
     * @return string
     */
    public function showHour($separator = ':', $showseconds = true)
    {
        if ($this->hour !='' && $this->minutes !='' && $this->seconds !='') {
            if ($this->hour =='00'
                && $this->minutes =='00' && $this->seconds =='00'
            ) {
                return _('Actually');
            } else {
                $hora= $this->hour.$separator.$this->minutes;
                if ($showseconds) {
                    $hora.=$separator.$this->seconds;
                }
                return $hora;
            }
        }
    }

    /**
     * Get month by name
     *
     * @param integer $month month
     *
     * @return string
     */
    public static function getMonthName($month)
    {
        $year[1] = _('January');
        $year[]  = _('February');
        $year[]  = _('March');
        $year[]  = _('April');
        $year[]  = _('May');
        $year[]  = _('June');
        $year[]  = _('July');
        $year[]  = _('August');
        $year[]  = _('September');
        $year[]  = _('October');
        $year[]  = _('November');
        $year[]  = _('December');
        return $year[(int)$month];
    }

    /**
     * Get day by name
     *
     * @param integer $day day
     *
     * @return string
     */
    public static function getDayName($day)
    {
        $week[1] = _('Monday');
        $week[]  = _('Tuesday');
        $week[]  = _('Wednesday');
        $week[]  = _('Thursday');
        $week[]  = _('Friday');
        $week[]  = _('Saturday');
        $week[]  = _('Sunday');
        return $week[(int)$day];
    }

    /**
     * Determine if date
     *
     * @param string $date date
     *
     * @return boolean
     */
    public static function isDate($date)
    {
        if (preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $date)) {
            return true;
        } else {
            return false;
        }
    }

    public function isToday()
    {
        $date=getdate();
        if ($date['mday'] == $this->day
            && $date['mon'] == $this->month
            && $date['year'] == $this->year
        ) {
            return true;
        }
        return false;
    }

    /**
     * Difference between dates
     *
     * @param number $year    year
     * @param number $month   month
     * @param number $day     day
     * @param number $hour    hour
     * @param number $minutes minutes
     * @param number $seconds seconds
     * @param number $diffin  diff type
     *
     * @return integer
     */
    public function diffToDate($year, $month, $day, $hour, $minutes, $seconds, $diffin = Date::SECONDS)
    {
        if ($this->isDateTimeEmpty()) {
            return 0;
        }
        $time1 = mktime($this->hour, $this->minutes, $this->seconds, $this->month, $this->day, $this->year);
        $time2 = mktime($hour, $minutes, $seconds, $month, $day, $year);

        $diff= $time1-$time2;
        switch ($diffin) {
            case Date::SECONDS:
                return $diff;
                break;
            case Date::MINUTES:
                return round($diff/60, 0);
                break;
            case Date::HOURS:
                return round($diff/3600, 0);
                break;
            case Date::DAYS:
                return round($diff/86400, 0);
                break;
            case Date::MONTHS:
                // TODO: make better
                return round($diff/2592000, 0);
                break;
            case Date::YEARS:
                // TODOS: make better
                return round($diff/31536000, 0);
        }
    }

    /**
     * Diference between now
     *
     * @param integer $diffin Return type
     *
     * @return integer
     */
    public function diffToNow($diffin = Date::SECONDS)
    {
        if ($this->isDateEmpty()) {
            return false;
        }
        $time1 = mktime(
            (float)$this->hour,
            (float)$this->minutes,
            (float)$this->seconds,
            (float)$this->month,
            (float)$this->day,
            (float)$this->year
        );
        $time2 = time();
        $diff= $time1-$time2;
        switch ($diffin) {
            case Date::SECONDS:
                return (int)$diff;
                break;
            case Date::MINUTES:
                return (int)round($diff/60, 0);
                break;
            case Date::HOURS:
                return (int)round($diff/3600, 0);
                break;
            case Date::DAYS:
                return (int)round($diff/86400, 0);
                break;
            case Date::MONTHS:
                // TODO: make better
                return (int)round($diff/2592000, 0);
                break;
            case Date::YEARS:
                // TODOS: make better
                return (int)round($diff/31536000, 0);
        }
    }

    /**
     * Diference between now by name
     *
     * @return string
     */
    public function diffToNowByName()
    {
        if (!$this->isDateTimeEmpty()) {
            $time1 = mktime($this->hour, $this->minutes, $this->seconds, $this->month, $this->day, $this->year);
            $time2 = time();
            $diff= $time1-$time2;

            if (abs($diff)>31536000) {
                // TODOS: make better
                if ($diff>0) {
                    return _('On ').ceil(abs($diff)/31536000)._(' years');
                } else {
                    /*TODO: mirar el "Hace" con gettext*/
                    return _('Since ').ceil(abs($diff)/31536000)._(' years ago');
                }
            } elseif (abs($diff)>2592000) {
                // TODO: make better
                if ($diff>0) {
                    return _('On ').ceil(abs($diff)/2592000)._(' months');
                } else {
                    /*TODO: mirar el "Hace" con gettext*/
                    return _('Since ').ceil(abs($diff)/2592000)._(' months ago');
                }
            } elseif (abs($diff)>86400) {
                if ($diff>0) {
                    return _('On ').ceil(abs($diff)/86400)._(' days');
                } else {
                    /*TODO: mirar el "Hace" con gettext*/
                    return _('Since ').ceil(abs($diff)/86400)._(' days ago');
                }
            } elseif (abs($diff)>3600) {
                if ($diff>0) {
                    return _('On ').ceil(abs($diff)/3600)._(' hours');
                } else {
                    /*TODO: mirar el "Hace" con gettext*/
                    return _('Since ').ceil(abs($diff)/3600)._(' hours ago');
                }
            } elseif (abs($diff)>60) {
                if ($diff>0) {
                    return _('On ').ceil(abs($diff)/60)._(' minutes');
                } else {
                    /*TODO: mirar el "Hace" con gettext*/
                    return _('Since ').ceil(abs($diff)/60)._(' minutes ago');
                }
            } else {
                if ($diff>0) {
                    return _('On ').ceil(abs($diff))._(' seconds');
                } else {
                    /*TODO: mirar el "Hace" con gettext*/
                    return _('Since ').ceil(abs($diff))._(' seconds ago');
                }
            }
        }
    }

    /**
     * Difference time to now by name
     *
     * @return string
     */
    public function diffTimeToNowByName()
    {
        if (!$this->isTimeEmpty()) {
            $date = getdate();
            $time1 = mktime($this->hour, $this->minutes, $this->seconds, $date['mon'], $date['mday'], $date['year']);
            $time2 = time();
            $diff = $time1 - $time2;
            if (abs($diff) > 3600) {
                if ($diff > 0) {
                    return _('On ') . ceil(abs($diff) / 3600) . _(' hours');
                } else {
                    /*TODO: mirar el "Hace" con gettext*/
                    return _('Since ') . ceil(abs($diff) / 3600) . _(' hours ago');
                }
            } elseif (abs($diff) > 60) {
                if ($diff > 0) {
                    return _('On ') . ceil(abs($diff) / 60) . _(' minutes');
                } else {
                    /*TODO: mirar el "Hace" con gettext*/
                    return _('Since ') . ceil(abs($diff) / 60) . _(' minutes ago');
                }
            } else {
                if ($diff > 0) {
                    return _('On ') . ceil(abs($diff)) . _(' seconds');
                } else {
                    /*TODO: mirar el "Hace" con gettext*/
                    return _('Since ') . ceil(abs($diff)) . _(' seconds ago');
                }
            }
            return $diff;

        }
    }

    /**
     * Date minus minutes
     *
     * @param string  $date    date
     * @param integer $minutes minutes
     *
     * @return Fecha
     */
    public static function minusMinutes($date, $minutes)
    {
        $newtime = strtotime('-' . $minutes . ' minute', strtotime($date));
        $date = new Fecha();
        $date->setDateTimeFromDB(date('Y-m-d H:i:s', $newtime));
        return $date;
    }
}
