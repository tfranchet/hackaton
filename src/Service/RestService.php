<?php

namespace App\Service;

class RestService
{
    public function requestRestApi($endpoint, $method, $data = null){
        $url = 'https://hackathon-rest-app.azurewebsites.net/api/' . $endpoint;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        switch ($method){
            case 'GET' : break;
            case 'POST' : curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            break;
            case 'PUT' : curl_setopt($ch, CURLOPT_PUT, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
        }
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $head = json_decode($head, true);
        if($httpCode < 400){
            return $head;
        }
        return null;
    }

    public function getEdition($date){
        $res = explode('-', $date)[0];
        return $res;
    }
}