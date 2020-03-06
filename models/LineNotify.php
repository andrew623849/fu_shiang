<?php

namespace app\models;



class LineNotify
{
	public static  $clientId = 'pdIDlXwhecWpEIsHSwJHKw';
	public static  $clientSecret = 'EVBItEZPDw525sSop0zFPqVJCMo9xR7NU84x0P6JBkk';
	public static $callback = 'http://fushiang.cowbtest.com/backend/person';


    /**
     * 傳送notify
     * @param string $token
     * @param array $data
     * @return bool
     * @throws Exception
     */
    function snedNotify($token, $data)
    {
        $url = "https://notify-api.line.me/api/notify";
        $type = "POST";
        $header = [
            "Authorization:	Bearer " . $token,
            "Content-Type: multipart/form-data"
        ];
        if (!empty($data["imageFile"])) {
            $data["imageFile"] = curl_file_create($data["imageFile"]);
        }
        $response = self::curl($url, $type, $data, [], $header);
        $response = json_decode($response, true);
        if ($response["status"] != "200") {
        	return false;
        }
        return $response;

    }


    /**
     * 取得OAuth2
     */
    function authorization()
    {
        $url = "https://notify-bot.line.me/oauth/authorize";
        $data = [
            "response_type" => "code",
            "client_id" => self::$clientId,
            "redirect_uri" => self::$callback,
            "scope" => "notify",
            "state" => "csrf_token",
			"response_mode"=>"form_post"
		];
        $url = $url . "?" . http_build_query($data);
        return $url;
//        header("Location: " . $url);
    }

    /**
     * 使用OAuth2的code 取得token
     * @param  string $code
     * @return mixed
     * @throws Exception
     */
    function getToken($code)
    {
        $url = "https://notify-bot.line.me/oauth/token";
        $type = "POST";
        $data = [
            "grant_type" => "authorization_code",
            "code" => $code,
            "redirect_uri" => self::$callback,
            "client_id" => self::$clientId,
            "client_secret" => self::$clientSecret,
        ];
        $header = [
            "Content-Type: application/x-www-form-urlencoded"
        ];
        $response = self::curl($url, $type, $data, [], $header);
        $response = json_decode($response, true);
        return $response["access_token"];
    }

    /**
     * 連動解除
     * @param  string $token
     * @return bool
     * @throws Exception
     */
    function rmToken($token)
    {
        $url = "https://notify-api.line.me/api/revoke";
        $type = "POST";
        $header = [
            "Authorization:	Bearer " . $token,
            "Content-Type: application/x-www-form-urlencoded"
        ];
        $response = self::curl($url, $type, [], [], $header);
        $response = json_decode($response, true);
        if ($response["status"] != "200") {
        	return false;
        }
        return true;

    }

    /**
     * curl
     * @param  string $url 網址
     * @param  string $type GET or POST
     * @param  array $data 資料
     * @param  array $options curl 設定
     * @param  array $header header
     * @return bool|string
     * @throws Exception
     */
    private function curl($url, $type = "GET", $data = [], $options = [], $header = [])
    {
        $ch = curl_init();
        if (strtoupper($type) == "GET") {
            $url = $url . "?" . http_build_query($data);
        } else {//POST
            if (in_array("Content-Type: multipart/form-data", $header)) {
                $options = [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $data
                ];
            } else {
                $options = [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => http_build_query($data)
                ];
            }
        }
        $defaultOptions = [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_RETURNTRANSFER => true,        // 不直接出現回傳值
            CURLOPT_SSL_VERIFYPEER => false,        // ssl
            CURLOPT_SSL_VERIFYHOST => false,        // ssl
            CURLOPT_HEADER => true                    //取得header
        ];
        $options = $options + $defaultOptions;
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $response = substr($response, $headerSize);
        return $response;
    }
}
