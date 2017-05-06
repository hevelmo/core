<?php
//namespace Medigraf;

/**
 * This class 
 * 
 * @author Francisco Javier Corona Sánchez <javier@medigraf.com.mx>
 * @copyright 2017
 */
class Curl
{
    private $apiUrl;
 
    /**
     * Description
     * @param type $apiUrl 
     * @return type
     */ 
    function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * Description
     * @param type $url 
     * @return type
     */
    public function routeGet($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $stringResponse = curl_exec($ch);
        $jsonResponse   = json_decode($stringResponse);
        curl_close($ch);
        return $jsonResponse;
    }
    
    /**
     * Description
     * @param type $url 
     * @param type $data 
     * @return type
     */
    public function routePost($url, $data)
    {
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