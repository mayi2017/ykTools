<?php
class httpRequest
{
    public static function curlPost($url, $param, $is_json = false, $parm_arr = [])
    {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== false) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_NOSIGNAL, 1);
        curl_setopt($oCurl, CURLOPT_TIMEOUT_MS, 12000);
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT_MS, 3000);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $param);

        if ($parm_arr) {
            foreach ($parm_arr as $k => $v) {
                curl_setopt($oCurl, constant($k), $v);
            }
        }
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        if ($is_json) {
            curl_setopt($oCurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($param)));
        }
        $sContent = curl_exec($oCurl);
        $status = curl_getinfo($oCurl);
        //echo json_encode($status);
        //失败尝试重连
        $times = 2;
        while (isset($status) && $status['http_code'] != 200 && $times > 0) {
            $sContent = curl_exec($oCurl);
            $status = curl_getinfo($oCurl);
            $times--;
        }
        //还有错误提交日志
        if (curl_errno($oCurl)) {
            $error_num = sprintf('Curl error message: %s, error no: %s, url: %s, params: %s, output: %s.', curl_error($oCurl), curl_errno($oCurl), $url, var_export($sContent, true));
        }
        @curl_close($oCurl);
        return $sContent;
    }

    public static function curlGet($url)
    {
        // return $url;
        $oCurl = curl_init();
        if (stripos($url, "https://") !== false) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        $sContent = curl_exec($oCurl);

        $status = curl_getinfo($oCurl);
        //失败尝试重连
        $times = 2;
        while (isset($status) && $status['http_code'] != 200 && $times > 0) {
            $sContent = curl_exec($oCurl);
            $status = curl_getinfo($oCurl);
            $times--;
        }
        //还有错误提交日志
        if (curl_errno($oCurl)) {
            $error_num = sprintf('Curl error message: %s, error no: %s, url: %s, params: %s, output: %s.', curl_error($oCurl), curl_errno($oCurl), $url, var_export($sContent, true));
        }
        @curl_close($oCurl);
        return $sContent;
    }

    public static function curlBase($url, $param = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($param)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        $status = curl_getinfo($curl);
        //失败尝试重连
        $times = 2;
        while (isset($status) && $status['http_code'] != 200 && $times > 0) {
            $output = curl_exec($curl);
            $status = curl_getinfo($curl);
            $times--;
        }
        //还有错误提交日志
        if (curl_errno($curl)) {
            $error_num = sprintf('Curl error message: %s, error no: %s, url: %s, params: %s, output: %s.', curl_error($curl), curl_errno($curl), $url, var_export($data, true), var_export($output, true));
        }
        @curl_close($curl);
        return $output;
    }
    
}
