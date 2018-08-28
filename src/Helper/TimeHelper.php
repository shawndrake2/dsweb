<?php

namespace DsWeb\Helper;

/** @deprecated  */
class TimeHelper
{
    const MINUTE = 60;
    const HOUR = 60 * self::MINUTE;
    const DAY = 24 * self::HOUR;

    public function getPlaytimeAsString($playtime)
    {
        $days = floor($playtime / self::DAY);

        $hourSeconds = $playtime % self::DAY;
        $hours = floor($hourSeconds / self::HOUR);

        $minuteSeconds = $hourSeconds % self::HOUR;
        $minutes = floor($minuteSeconds / self::MINUTE);

        $remainingSeconds = $minuteSeconds % self::MINUTE;
        $seconds = ceil($remainingSeconds);

        return "${days} days, ${hours} hours, ${minutes} minutes, ${seconds} seconds";
    }
    
    public function getAuctionTimeAsString($listingDate)
    {
        $now = time();
        $difference = $now - $listingDate;

        if ($difference === 0) {
            // Instant
            return '<span style="font-weight:bold;">a few ms ago</span>';
        } else if ($difference < self::MINUTE) {
            // Few seconds ago
            return "<span style='font-weight:bold;'>${difference} secs</span>";
        } else if ($difference < self::HOUR) {
            // Few minutes ago
            $minutes = round($difference / self::MINUTE);
            return "<span style='font-weight:bold;'>${minutes} mins</span>";
        } else if ($difference < self::DAY) {
            // Few hours ago
            $hours = floor($difference / self::HOUR);
            $seconds = $difference % self::HOUR;
            $minutes = round($seconds / self::MINUTE);
            return "${hours} hrs, ${minutes} mins";
        } else {
            return date('M d Y, g:i a', $listingDate);
        }
    }
}