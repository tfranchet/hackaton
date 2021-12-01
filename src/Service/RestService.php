<?php

namespace App\Service;

class RestService
{
    public function requestRestApi($endpoint, $method, $data = null){
        $url = 'http://azurehackathon-rest-app.azurewebsites.net/api/' . $endpoint;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        switch ($method){
            case 'GET' : break;
            case 'POST' : curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                            break;
            case 'PUT' : curl_setopt($ch, CURLOPT_PUT, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
        }
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpCode < 400){
            return $head;
        }
        return null;
    }
}