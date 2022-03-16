<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class ApiHelper {

    public function url($endpoint)
    {
        return Config::get('app.api_url')."/api/$endpoint";
    }

    public function hit($url, $method, $token = '', $data = [])
    {
        $header = [
            'Content-Type: application/json',
        ];

        if ($token != '') {
            array_push($header, "Authorization: Bearer {$token}");
        }

        $body = json_encode($data);

        return $this->exec($url, $method, $header, $body);
    }

    private function exec($url, $method, $header = [], $body = [])
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $response = json_encode([
                'status' => 'failed',
                'message' => curl_error($curl),
                'total_data' => 0,
                'data' => null
            ]);
        }

        curl_close($curl);
        return json_decode($response);
    }

}
