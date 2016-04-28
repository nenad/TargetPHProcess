<?php


namespace TargetPHProcess\Models;


use DateTime;

class TPDate extends DateTime
{
    public function __construct($dateString)
    {
        parent::__construct();
        # Convert Microsoft AJAX Date to PHP DateTIme
        # Examples:
        #    Date(1460379452000+0200)
        #    Date(1460379452000)
        $matches = [];
        preg_match('/Date\(([\d\+-]+)\)/', $dateString, $matches);
        if (count($matches) == 2) {
            $millisecondString = $matches[1];
            $offsetMilliseconds = 0;
            if (strpos($millisecondString, '+') !== false) {
                $splittedString = explode('+', $millisecondString);
                $milliseconds = (int)$splittedString[0];
                $hourOffset = $splittedString[1];
                $hour = (int)substr($hourOffset, 0, 2);
                $offsetMilliseconds = 3600 * $hour * 1000;
            } elseif (strpos($millisecondString, '-') !== false) {
                $splittedString = explode('-', $millisecondString);
                $milliseconds = (int)$splittedString[0];
                $hourOffset = $splittedString[1];
                $hour = (int)substr($hourOffset, 0, 2);
                $offsetMilliseconds = -3600 * $hour * 1000;
            } else {
                $milliseconds = (int)$millisecondString;
            }
            $this->setTimestamp(($milliseconds + $offsetMilliseconds) / 1000);
        } else {
            throw new \Exception('No valid timestamp given');
        }
    }
}