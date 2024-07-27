<?php

namespace App;

use App\Models\Job;
use App\Models\Requisition;
use Illuminate\Support\Str;

class Formula
{
    /**
     * Get Next Job Number
     */
    public static function nextJobSerial()
    {
        $number = Job::max('number');

        $serial_digit = 5;
        $padding_char = '0';

        $serial = Str::padLeft(++$number, $serial_digit, $padding_char);

        return $serial;
    }

    /**
     * Get Next Requisition Number
     */

    // public static function nextRequisition()
    // {
    //     $index = Requisition::max('serial');

    //     $serial_digit = 5;
    //     $padding_char = "0";

    //     $prefix = "";
    //     $serial = Str::padLeft(++$index, $serial_digit, $padding_char);

    //     return [
    //         'serial' => $serial,
    //         'prefix' => $prefix,
    //     ];
    // }

    /**
     * Get Next Delivery Number
     */

    // public static function nextDeliveryNumber()
    // {
    //     $index = Job::count();
    //     $serial_digit = 3;
    //     $padding_char = "0";

    //     $serial = Str::padLeft(++$index, $serial_digit, $padding_char);
    //     return 'LAN' . date('y') . date('m') . $serial;
    // }
}
