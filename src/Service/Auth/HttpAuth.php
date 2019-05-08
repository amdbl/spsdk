<?php

namespace Amdbl\Sp\Service\Auth;
class HttpAuth
{
    protected $authServer = "";

    protected $method = "";

    protected $appId = "";

    protected $appSecret = "";

    public function __construct($appId, $appSecret, $authServer)
    {
        if (empty($appId)) {
            throw new \Exception("appid is undefined");
        }

        if (empty($appSecret)) {
            throw new \Exception("appsecret is undefined");
        }

        if (empty($authServer)) {
            throw new \Exception("authserver is undefined");
        }

        $this->authServer = $authServer;
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    protected function run($data, $headers = false)
    {
        $url = $this->authServer . $this->method;

        $data['client_id'] = $this->appId;
        $data['client_secret'] = $this->appSecret;

        if(!$headers){
            $headers = [];
        }
        $headers[] = 'Content-Type: application/json;';

        return $this->curl($url,json_encode($data), $headers);
    }

    private function curl($url, $postData, $headers = false)
    {
        $ch = curl_init();
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($postData) {
            if (is_array($postData)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            } else { // json格式
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            }
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
//        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($ch);
        $curl_log = curl_getinfo($ch);
        curl_close($ch);
        if ($output and $json = json_decode($output, true)) {
            return $json;
        } else {
            $res = array('status' => 'error', 'msg' => '请求错误', 'data' => $curl_log,'param'=>$postData);
            return $res;
        }
    }
}