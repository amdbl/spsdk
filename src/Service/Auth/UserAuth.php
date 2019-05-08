<?php
namespace Amdbl\Sp\Service\Auth;
class UserAuth extends HttpAuth
{
    protected $method = "/oauth/getuserinfo";

    public function userInfo($token)
    {
        $data = [
            "grant_type" => 'client_credentials',
            "token" => $token
        ];
        return $this->run($data);
    }
}