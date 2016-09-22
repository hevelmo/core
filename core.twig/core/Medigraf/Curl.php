<?php

//namespace Medigraf;

class Curl {
    
    private $apiUrl;
    
    function __construct($apiUrl) {
        $this->apiUrl = $apiUrl;
    }
    
    public function routeGet($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $stringResponse = curl_exec($ch);
        $jsonResponse   = json_decode($stringResponse);
        curl_close($ch);
        return $jsonResponse;
    }
    
    public function routePost($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $stringResponse = curl_exec($ch);
        $jsonResponse   = json_decode($stringResponse);
        curl_close($ch);
        return $jsonResponse;
    }
    
}
