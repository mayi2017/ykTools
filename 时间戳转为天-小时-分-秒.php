<?php
/**
 * 将时间戳转为天、小时、分、秒
 */
function formatTime($time = 0, $needSecond = false)
{
    $day = floor($time / (3600 * 24));
    $hour = floor(($time - $day * 3600 * 24) / 3600);
    $minute = floor(($time - $day * 3600 * 24 - $hour * 3600) / 60);

    if ($needSecond) {
        $second = ($time - $day * 3600 * 24 - $hour * 3600) % 60;
    } else {
        $minute += 1;
        $second = 0;
    }
    $res = sprintf("%s %s %s %s",
        $day    ? $day . '天' : '',
        $hour   ? $hour . '时' : '',
        $minute ? $minute . '分' : '',
        $second ? $second . '秒' : ''
    );
    return $res;
}

// 举个栗子，结果为：60天 4时 48分 34秒
echo formatTime(5201314, true);

// 举个栗子，结果为：60天 4时 49分 
echo formatTime(5201314);