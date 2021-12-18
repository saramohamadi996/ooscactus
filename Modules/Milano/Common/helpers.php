<?php

use Morilog\Jalali\Jalalian;


function newFeedback($title = 'عملیات موفقیت آمیز', $body = 'عملیات با موفقیت انجام شد', $type = 'success')
{
    $session = session()->has('feedbacks') ? session()->get('feedbacks') : [];
    $session[] = ['title' => $title, "body" => $body, "type" => $type];
    session()->flash('feedbacks', $session);
}

/**
 *
Convert date format from carbon to jalali.
 * @param $date
 * @param string $format
 * @return \Carbon\Carbon|null
 */
function dateFromJalali($date, $format = "Y/m/d")
{
    return $date ? Jalalian::fromFormat($format, $date)->toCarbon() : null;
}

/**
 * Get date from jalali format and save to carbon format.
 * @param $date
 * @param string $format
 * @return string
 */
function getJalaliFromFormat($date, $format = "Y-m-d")
{
    return Jalalian::fromCarbon(Carbon\Carbon::createFromFormat($format, $date))->format($format);
}

/**
 * create date From Carbon.
 * @param \Carbon\Carbon $carbon
 * @return Jalalian
 */
//function createFromCarbon(Carbon\Carbon $carbon)
//{
//    return Jalalian::fromCarbon($carbon);
//}

function createFromCarbon(Carbon\Carbon $carbon)
{
    return Jalalian::fromCarbon($carbon);
}
