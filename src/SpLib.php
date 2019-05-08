<?php

namespace Amdbl\Sp;

use Amdbl\Sp\Service\Auth\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class SpLib
{
    protected $authServer = '';

    protected $appId = '';

    protected $appSecret = '';

    public function __construct()
    {
        $environment = App::environment();
        if ($environment == "production") {
            $this->authServer = Config::get('splayer.auth_server_prod');
        } else {
            $this->authServer = Config::get('splayer.auth_server_test');
        }

        $this->appId = Config::get('splayer.app_id');
        $this->appSecret = Config::get('splayer.app_secret');
    }

    public function authUserInfo($token)
    {
        $pmt = new UserAuth($this->appId, $this->appSecret, $this->authServer);
        $pmtRes = $pmt->userInfo($token);
        return $pmtRes;
    }


    public function authUserRequest(Request $request)
    {
        $authCode = $request->get("token", "");
        if (empty($authCode)) {
            return false;
        }

        try {
            //ip验证
            $this->ipIsAllowed($request);
            $authRes = $this->authUserInfo($authCode);
            if ($authRes && $authRes['error'] == 0) {
                $userInfo = $authRes['data'];
                return $userInfo;
            }
        } catch (\Exception $e) {

        }
        return false;
    }

    private function ipIsAllowed(Request $request)
    {
        $ip = $request->getClientIp();
        $whiteArr = Config::get("splayer.auth_ip_whitelist");
        if (in_array($ip, $whiteArr)) {
            throw new \Exception("");
        }
    }

    public function redirectBack()
    {
        $loginUrl = Config::get('splayer.auth_login_url');
        return redirect($loginUrl, 301);
    }

}