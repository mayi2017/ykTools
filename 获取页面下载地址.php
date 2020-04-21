<?php
require_once './httpRequest.php';

function getPageContent($url = '')
{
    $content = httpRequest::curlGet($url);

    return $content;
}

function getDownUrl($url = '')
{
    $content = getPageContent($url);

    $return = [];
    if (preg_match('/downurls="(.*?)"/', $content, $mats)) {
        $downurls = $mats[1];
        $downarr = explode('#', $downurls);
        foreach ($downarr as $v) {
            if (empty($v)) {
                continue;
            }
            $varr = explode('$', $v);
            $return[$varr[0]] = $varr[1];
        }
    }
    return $return;
}

$mats = getDownUrl('https://www.993dy.com/vod-detail-id-56142.html');
print_r($mats);
