<?php

namespace App\Traits;

use App\Models\SiteInfo;
use App\Models\SMSConfig;
use Exception;
use GuzzleHttp\Client;

trait SMS
{
    /**
     * @param $to string 01xxxxxxxxx
     * @param $message string must be a double quoted string
     * @return bool|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendSMS($to, $message)
    {
        $info = SiteInfo::first();
        // $config = SMSConfig::first();

        $message .= "\n- " . $info->name;

        // if ($config) {
            // $url = 'http://sms.sslwireless.com/pushapi/dynamic/server.php'
            //     . '?user=' . $config->username
            //     . '&pass=' . $config->password
            //     . '&sid=' . $config->sender_id
            //     . '&msisdn=' . $to
            //     . '&sms=' . mb_strtoupper(bin2hex(mb_convert_encoding($message, 'UTF-16BE', 'UTF-8')))
            //     . '&csmsid=' . uniqid("", true);
            //api_token = 'Anaz-17e6ebee-31b1-4e05-a87a-dbae1937c915'
            // sid = ANAZBDAPI(masking), ANAZNONAPI(Non-Masking)
            
            $url = 'https://smsplus.sslwireless.com/api/v3/send-sms';
                $params = [
                    "api_token" => "Anaz-17e6ebee-31b1-4e05-a87a-dbae1937c915",
                    "sid" => "ANAZBDAPI",
                    "msisdn" => $to,
                    "sms" => $message,
                    "csms_id" => uniqid("", false)
                ];

            try {
                $res = $this->callApi($url,json_encode($params));
                return true;
            } catch (Exception $e) {
               return $e->getMessage();
            }
        // }

        return false;
    }

    private function sendSMSNonMask($to, $message)
    {
        $info = SiteInfo::first();
        // $config = SMSConfig::first();

        $message .= "\n- " . $info->name;

        // if ($config) {
            // $url = 'http://sms.sslwireless.com/pushapi/dynamic/server.php'
            //     . '?user=' . $config->username
            //     . '&pass=' . $config->password
            //     . '&sid=' . $config->sender_id
            //     . '&msisdn=' . $to
            //     . '&sms=' . mb_strtoupper(bin2hex(mb_convert_encoding($message, 'UTF-16BE', 'UTF-8')))
            //     . '&csmsid=' . uniqid("", true);
            //api_token = 'Anaz-17e6ebee-31b1-4e05-a87a-dbae1937c915'
            // sid = ANAZBDAPI(masking), ANAZNONAPI(Non-Masking)
            
            $url = 'https://smsplus.sslwireless.com/api/v3/send-sms';
                $params = [
                    "api_token" => "Anaz-17e6ebee-31b1-4e05-a87a-dbae1937c915",
                    "sid" => "ANAZNONAPI",
                    "msisdn" => $to,
                    "sms" => $message,
                    "csms_id" => uniqid("", false)
                ];

            try {
                $res = $this->callApi($url,json_encode($params));
                return true;
            } catch (Exception $e) {
                dd($e);
               return $e->getMessage();
            }
        // }

        return false;
    }

    function callApi($url, $params)
    {
        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'accept:application/json'
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}
