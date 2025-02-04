<?php
/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 *
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     HDVinnie
 */

namespace App\Helpers;

class StringHelper
{
    const KIB = 1024;

    const MIB = 1024 * 1024;

    const GIB = 1024 * 1024 * 1024;

    const TIB = 1024 * 1024 * 1024 * 1024;

    const PIB = 1024 * 1024 * 1024 * 1024 * 1024;

    public static function generateRandomString($length = 20)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $string;
    }

    public static function formatBytes($bytes, $precision = 2)
    {
        $bytes = max($bytes, 0);
        $suffix = 'B';
        $value = $bytes;
        if ($bytes >= self::PIB) {
            $suffix = 'PiB';
            $value = $bytes / self::PIB;
        } elseif ($bytes >= self::TIB) {
            $suffix = 'TiB';
            $value = $bytes / self::TIB;
        } elseif ($bytes >= self::GIB) {
            $suffix = 'GiB';
            $value = $bytes / self::GIB;
        } elseif ($bytes >= self::MIB) {
            $suffix = 'MiB';
            $value = $bytes / self::MIB;
        } elseif ($bytes >= self::KIB) {
            $suffix = 'KiB';
            $value = $bytes / self::KIB;
        }

        return round($value, $precision).' '.$suffix;
    }

    /**
     * @method timeRemaining
     *
     * @param  time  $seconds  in bigInt
     *
     * @return string
     */
    public static function timeRemaining($seconds)
    {
        $minutes = 0;
        $hours = 0;
        $days = 0;
        $weeks = 0;
        $months = 0;
        $years = 0;

        $seconds = config('hitrun.seedtime') - $seconds;

        if ($seconds == 0) {
            return 'N/A';
        }
        while ($seconds >= 31536000) {
            $years++;
            $seconds -= 31536000;
        }
        while ($seconds >= 2592000) {
            $months++;
            $seconds -= 2592000;
        }
        while ($seconds >= 604800) {
            $weeks++;
            $seconds -= 604800;
        }
        while ($seconds >= 86400) {
            $days++;
            $seconds -= 86400;
        }
        while ($seconds >= 3600) {
            $hours++;
            $seconds -= 3600;
        }
        while ($seconds >= 60) {
            $minutes++;
            $seconds -= 60;
        }
        $years = ($years == 0) ? '' : $years.trans('common.abbrev-years');
        $months = ($months == 0) ? '' : $months.trans('common.abbrev-months');
        $weeks = ($weeks == 0) ? '' : $weeks.trans('common.abbrev-weeks');
        $days = ($days == 0) ? '' : $days.trans('common.abbrev-days');
        $hours = ($hours == 0) ? '' : $hours.trans('common.abbrev-hours');
        $minutes = ($minutes == 0) ? '' : $minutes.trans('common.abbrev-minutes');
        $seconds = ($seconds == 0) ? '' : $seconds.trans('common.abbrev-seconds');

        return $years.$months.$weeks.$days.$hours.$minutes.$seconds;
    }

    /**
     * @method timeElapsed
     *
     * @param  time  $seconds  in bigInt
     *
     * @return string
     */
    public static function timeElapsed($seconds)
    {
        $minutes = 0;
        $hours = 0;
        $days = 0;
        $weeks = 0;
        $months = 0;
        $years = 0;

        if ($seconds == 0) {
            return 'N/A';
        }
        while ($seconds >= 31536000) {
            $years++;
            $seconds -= 31536000;
        }
        while ($seconds >= 2592000) {
            $months++;
            $seconds -= 2592000;
        }
        while ($seconds >= 604800) {
            $weeks++;
            $seconds -= 604800;
        }
        while ($seconds >= 86400) {
            $days++;
            $seconds -= 86400;
        }
        while ($seconds >= 3600) {
            $hours++;
            $seconds -= 3600;
        }
        while ($seconds >= 60) {
            $minutes++;
            $seconds -= 60;
        }
        $years = ($years == 0) ? '' : $years.trans('common.abbrev-years');
        $months = ($months == 0) ? '' : $months.trans('common.abbrev-months');
        $weeks = ($weeks == 0) ? '' : $weeks.trans('common.abbrev-weeks');
        $days = ($days == 0) ? '' : $days.trans('common.abbrev-days');
        $hours = ($hours == 0) ? '' : $hours.trans('common.abbrev-hours');
        $minutes = ($minutes == 0) ? '' : $minutes.trans('common.abbrev-minutes');
        $seconds = ($seconds == 0) ? '' : $seconds.trans('common.abbrev-seconds');

        return $years.$months.$weeks.$days.$hours.$minutes.$seconds;
    }

    public static function ordinal($number)
    {
        $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number.'th';
        } else {
            return $number.$ends[$number % 10];
        }
    }
}
