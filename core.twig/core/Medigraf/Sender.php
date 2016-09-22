<?php

//namespace Medigraf;

class Sender {
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- PROPERTIES -----------------------------------------
    //---------------------------------------------------------------------------------------------
    
    private $mandrill;
    private $message;
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- CONSTRUCT ------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    function __construct($mandrill) {
        $this->mandrill = $mandrill;
        $this->message  = array(
            "important" => false,
            "track_opens" => true,
            "track_clicks" => true,
            "auto_text" => null,
            "auto_html" => null,
            "inline_css" => null,
            "url_strip_qs" => null,
            "preserve_recipients" => null,
            "view_content_link" => null,
            "bcc_address" => null,
            "tracking_domain" => null,
            "signing_domain" => null,
            "return_path_domain" => null,
            "merge" => true
        );
    }

    public function __send($data) {
        foreach ($data as $key => $value) {
            if (!empty($value)) {
                $this->message[$key] = $value;
            }
        }
        ksort($this->message);
        $async  = false;
        $ipPool = "Main Pool";
        $sendAt = "";
        try {
            $result = $this->mandrill->messages->send($this->message, $async, $ipPool, $sendAt);
        } catch (Mandrill_Error $e) {
            //Mandrill errors are thrown as exceptions
            echo "A mandrill error occurred: " . get_class($e) . " - " . $e->getMessage();
            //A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id "customer-123"
            throw $e;
        }
    }
    
}
