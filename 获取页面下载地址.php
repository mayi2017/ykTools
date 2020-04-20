<?php
require_once 'httpRequest.php';

function getPageContent($url = '')
{
    $content = httpRequest::curlGet($url);
    
    return $content;
}

function getDownUrl($url = '')
{
    $content = getPageContent($url);
    if (preg_match_all('/<input\s+name="CopyAddr1"\s+.*? value="(.*?)">/', $content, $mats)) {
        return $mats;
    } else {
        return [];
    }
}

$mats = getDownUrl('https://www.993dy.com/vod-detail-id-56142.html');
print_r($mats);