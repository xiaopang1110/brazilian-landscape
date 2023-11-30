<?php
/**
 * 萌果科技.
 * 作者: 王磊
 * 日期: 2023-3-11
 * 时间: 15:34
 */

class RequestApi {

    public function sendRequest($url, $params, $method = 'post', $data_type = 'json', $get_response = false, $direct_result = false) {
        if ($method == 'get' && $params) {
            $url = $this->getExistsParams($url, $params);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
            if ($params) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $res = curl_exec($ch);
        return $res;
    }

    public function httpRawPost($url, $dataString) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-AjaxPro-Method:ShowList',
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($dataString))
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function noSSLHttpRawPost($url, $dataString) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-AjaxPro-Method:ShowList',
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($dataString))
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**get参数拼接
     * @param $url
     * @param array $params
     * @return string
     */
    public function getExistsParams($url, array $params)
    {
        $query = parse_url($url, PHP_URL_QUERY);
        $query_string = http_build_query($params);
        if ($query) {
            $url .= '&' . $query_string;
        } else {
            $url .= '?' . $query_string;
        }
        return $url;
    }
}
