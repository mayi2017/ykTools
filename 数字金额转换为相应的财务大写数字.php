<?php
/**
 * 根据一个数字金额转换为相应的财务大写数字
 * 暂不支持大于12位的数字，有待改进
 * create： 2020-03-29 22:52:03
 */
function numToBigWord($num = 0.00)
{
    $n        = sprintf("%.2f", $num);
    $coums    = ["零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖"];
    $cnyunits = ["角", "分"];
    $grees    = ["元", "拾", "佰", "仟", "万", "亿"];
    $nums     = explode('.', $n);
    $s_str    = $nums[0];           //截取小数点前几个字符
    $f_str    = $nums[1];           //截取小数点后几个字符
    $s_len    = strlen($s_str);     //整数长度
    $f_price  = '';
    //如果整数小于10
    if ($s_str < 10 && $s_str > 0) {
        $f_price .= $coums[$s_str] . $grees[0];
    } else if ($s_str == 0) {
        $f_price .= '';
    } else {
        if ($s_len <= 4) {
            $f_price .= big4($s_str, '元');
        } elseif ($s_len <= 8) {
            $f_price .= big4(substr($s_str, 0, -4), '万');
            $f_price .= big4(substr($s_str, -4), '元');
        } elseif ($s_len <= 12) {
            $f_price .= big4(substr($s_str, 0, -8), '亿');
            $f_price .= big4(substr($s_str, -8, -4), '万');
            $f_price .= big4(substr($s_str, -4), '元');
        }
    }
    //小数部分
    $ext = '';
    if ($f_str[0] == 0 && $f_str[1] == 0 && $f_price != '') {
        $ext .= '整';
    } else {
        for ($i = 0; $i <= 1; $i++) {
            if ($f_str[$i] != 0) {
                $ext .= $coums[$f_str[$i]] . $cnyunits[$i];
            }
        }
    }
    return   $f_price . $ext;
}

function big4($n, $unit)
{
    $coums   = ["零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖"];
    $grees   = ["", "拾", "佰", "仟", "万", "亿"];
    $s_len   = strlen($n);
    $f_price = '';
    $a       = false;
    $all0    = true;

    for ($i = $s_len - 1; $i >= 0; $i--) {
        // 个位
        $as = '';
        if ($n[$i] == 0 && $a) {
            $as = $coums[0];
            $a  = false;
        }
        if ($n[$i] != 0) {
            $all0 = false;
            $a    = true;
            $as   = $coums[$n[$i]] . $grees[$s_len - $i - 1];
        }
        $f_price = $as . $f_price;
    }

    if (!$all0 || $unit == '元') {
        return $f_price . $unit;
    } else {
        return $f_price;
    }
}

/* --------------------------------------------------- */

// 举个栗子，结果为：伍拾贰亿零壹佰叁拾肆万壹仟玖佰玖拾玖元陆角捌分
echo numToBigWord(5201341999.68);

// 举个栗子，结果为：贰佰零贰亿零壹佰万零叁佰贰拾玖元整
echo numToBigWord(20201000329);