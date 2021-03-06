<?php
/**
 * 根据日期获取是周几
 * dateString string 日期字符串
 * format string 返回的格式，周几的数字部分用“%s”代替
 * create： 2020-03-29 22:52:15
 */
function getWeekBydate($dateString = '', $format = '星期%s')
{
    if (empty($dateString)) {
        throw new Exception('第一个参数不可为空');
    }

    if (strpos($format, '%s') === false) {
        throw new Exception('第二个参数格式不对');
    }

    $week    = date('w', strtotime($dateString));

    $weekArr = ['日', '一', '二', '三', '四', '五', '六'];

    return sprintf($format, $weekArr[$week]);
}

/* --------------------------------------------------- */

// 举个栗子，结果为：星期一
echo getWeekBydate('2020-03-30');

// 举个栗子，结果为：周二 
echo getWeekBydate('2020-03-31', '周%s');