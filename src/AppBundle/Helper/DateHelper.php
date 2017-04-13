<?php

namespace AppBundle\Helper;

class DateHelper
{
    /**
     * @param int $depth
     * @return array
     */
    public static function getLimitEachMonth($depth = 12)
    {
        $result = [];
        for ($index = 1; $index <= $depth; $index++) {
            $result[] = new \DateTime(date('Y-m', strtotime(0 - $index . ' month')));
        }

        return $result;
    }

    /**
     * @param \DateTime $date
     * @return int
     */
    public static function getLimitAtMonth(\DateTime $date)
    {
        return cal_days_in_month(CAL_GREGORIAN, $date->format('m'), $date->format('Y'));
    }

    /**
     * @param \DateTime $date
     * @return \DateTime
     */
    public static function getLastDatetimeAtMonth(\DateTime $date)
    {
        $lastDay = clone $date;
        $day = self::getLimitAtMonth($lastDay);
        $lastDay->modify(sprintf('+%s day', $day - 1));

        return $lastDay;
    }
}
